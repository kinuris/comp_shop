<?php

namespace App\Livewire;

use App\Models\ApplicableDiscount;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\GeneralDiscount;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use Livewire\Attributes\Computed;
use App\Models\Product;
use App\Models\ProductSnapshot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSearch extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Session(key: 'items')]
    public array $selectedItems = array();

    #[Session(key: 'discounts')]
    public array $discountAssoc = array();

    #[Url(as: 'm')]
    public int $method;

    #[Url(as: 'd')]
    public int $generalDiscount;

    public function mount()
    {
        $this->method = PaymentMethod::all()->last()->id;
        $this->generalDiscount = -1;
    }

    #[Computed]
    public function totalPrice(): int
    {
        $prices = array_map(function ($id) {
            $product = Product::query()->find($id);

            if (isset($this->discountAssoc[$id])) {
                return Discount::query()->find($this->discountAssoc[$id])->solveFinal($product->price);
            }

            return $product->price;
        }, $this->selectedItems);

        return array_sum($prices);
    }

    #[Computed]
    public function itemsAndQuantity(): array
    {
        $result = [];
        foreach (array_count_values($this->selectedItems) as $id => $qty) {
            $product = Product::query()->find($id);

            array_push($result, [$product, $qty]);
        }

        return $result;
    }

    #[Computed]
    public function insufficient(): array
    {
        $grouped = array_count_values($this->selectedItems);
        $insufficient = array();

        foreach ($grouped as $id => $qty) {
            $record = Product::query()->find($id);
            $record->required = $qty;

            if ($record->stock_quantity < $qty) {
                array_push($insufficient, $record);
            }
        }

        return $insufficient;
    }

    public function resolveDiscount($id)
    {
        return Discount::query()->find($id);
    }

    public function chooseDiscount($pid)
    {
        $applicable = ApplicableDiscount::query()
            ->where('fk_product', '=', $pid)
            ->select(['fk_discount'])
            ->get()
            ->toArray();

        $applicable = array_map(fn ($apd) => $apd['fk_discount'], $applicable);

        $raw = Discount::query()
            ->where('disabled', '=', false)
            ->whereIn('id', $applicable)
            ->get();

        $discounts = array();
        foreach ($raw as $rec) {
            array_push($discounts, $rec);
        }

        $general = array();
        foreach (GeneralDiscount::all() as $rec) {
            $discount = Discount::query()->find($rec->fk_discount);
            if ($discount->disabled) {
                continue;
            }

            array_push($general, $discount);
        }

        $this->dispatch('show-discounts', discounts: array_merge($discounts, $general), product: Product::query()->find($pid));
    }

    public function applyDiscount($pid, $discount)
    {
        $this->discountAssoc[$pid] = $discount;
        $applicable = ApplicableDiscount::query()
            ->where('fk_product', '=', $pid)
            ->select(['fk_discount'])
            ->get()
            ->toArray();

        $applicable = array_map(fn ($apd) => $apd['fk_discount'], $applicable);

        $raw = Discount::query()
            ->where('disabled', '=', false)
            ->whereIn('id', $applicable)
            ->get();

        $discounts = array();
        foreach ($raw as $rec) {
            array_push($discounts, $rec);
        }

        $general = array();
        foreach (GeneralDiscount::all() as $rec) {
            $discount = Discount::query()->find($rec->fk_discount);
            if ($discount->disabled) {
                continue;
            }

            array_push($general, $discount);
        }

        $this->dispatch('show-discounts', discounts: array_merge($discounts, $general), product: Product::query()->find($pid));
    }

    public function getSelectedQuantity($id): int|null
    {
        $grouped = array_count_values($this->selectedItems);

        if (!isset($grouped[$id])) {
            return null;
        }

        return $grouped[$id];
    }

    public function checkout()
    {
        $grouped = array_count_values($this->selectedItems);
        if (empty($grouped)) {
            return;
        }

        // NOTE: Stock quantity checking
        $insufficient = array();
        $items = array();
        $quantities = array();
        foreach ($grouped as $id => $qty) {
            $record = Product::query()->find($id);
            array_push($items, $record);
            array_push($quantities, $qty);

            if ($record->stock_quantity < $qty) {
                array_push($insufficient, $record);
            }
        }

        if (count($insufficient) > 0) {
            $this->dispatch('insufficient', items: $insufficient);

            return;
        }

        // NOTE: Custom implementation of create method
        $transaction = PaymentTransaction::create(Auth::user()->user_id, $this->method, null);
        foreach ($grouped as $id => $qty) {
            $latestSnapshot = ProductSnapshot::latestOf($id);
            $record = Product::query()->find($id);

            for ($i = 0; $i < $qty; $i++) {
                Cart::query()->create([
                    'fk_payment_transaction' => $transaction->id,
                    'fk_product' => $id,
                    'fk_product_snapshot' => $latestSnapshot->id,
                    'fk_discount' => isset($this->discountAssoc[$id]) ? $this->discountAssoc[$id] : null,
                ]);
            }

            $record->update(['stock_quantity' => $record->stock_quantity - $qty]);
        }

        $this->dispatch(
            'checkout',
            items: $items,
            quantities: $quantities,
            transaction: $transaction,
            discounts: array_map(fn ($id) => Discount::query()->find($id), $this->discountAssoc),
            method: PaymentMethod::query()->find($transaction->fk_payment_method),
        );
        $this->selectedItems = array();
        $this->discountAssoc = array();
    }

    public function addProduct(int $id)
    {
        array_push($this->selectedItems, $id);
    }

    public function removeProduct(int $id)
    {
        $index = false;

        // NOTE: this is a reimplementation of array_search that searches backwards
        for ($i = count($this->selectedItems) - 1; $i >= 0; $i--) {
            if ($this->selectedItems[$i] == $id) {
                $index = $i;
                break;
            }
        }

        // NOTE: Kinanglan gid === false kay weird shit casting sang php
        if ($index === false) {
            return;
        }

        if (count(array_filter($this->selectedItems, fn ($pid) => $id === $pid)) === 1) {
            unset($this->discountAssoc[$id]);
        }

        unset($this->selectedItems[$index]);

        $this->selectedItems = array_values($this->selectedItems);
    }

    public function render()
    {
        $products = Product::query()
            ->where('product_name', 'LIKE', "%$this->search%")
            ->where('available', '=', '1');

        // TODO: Change to query Discount where id exists in GeneralDiscount
        $generalDiscounts = DB::table('general_discounts')
            ->join('discounts', 'discounts.id', '=', 'general_discounts.fk_discount')
            ->select([
                'discounts.id',
                'discounts.type',
                'discounts.name',
                'discounts.percentage_discount',
                'discounts.absolute_discount',
            ])
            ->get();

        if ($products->get()->count() <= 12) {
            $products = $products->paginate(12, page: 1);
        } else {
            $products = $products->paginate(12);
        }

        $paymentMethods = PaymentMethod::all();

        return view('livewire.product-search')
            ->with('products', $products)
            ->with('methods', $paymentMethods)
            ->with('discounts', $generalDiscounts);
    }

    public function logout()
    {
        redirect('/logout');
    }
}
