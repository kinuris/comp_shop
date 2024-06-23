<?php

namespace App\Http\Controllers;

use App\Models\ApplicableDiscount;
use App\Models\Discount;
use App\Models\GeneralDiscount;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::query()->where('disabled', '=', 0)
            ->get();

        return view('discount.index')->with('discounts', $discounts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return view('discount.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('type');

        if ($type === 'absolute') {
            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('discounts')->where(fn (Builder $q) => $q->where('disabled', false)),
                ],
                'applicable' => ['nullable', 'array'],
                'type' => ['required', 'in:absolute,percentage'],
                'value' => ['required', 'numeric'],
            ]);

            $validated['absolute_discount'] = $validated['value'];
        } else if ($type === 'percentage') {
            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('discounts')->where(fn (Builder $q) => $q->where('disabled', false)),
                ],
                'applicable' => ['nullable', 'array'],
                'type' => ['required', 'in:absolute,percentage'],
                'value' => ['required', 'numeric', 'min:1', 'max:100'],
            ]);

            $validated['percentage_discount'] = $validated['value'];
        } else {
            return back();
        }

        $inserted = Discount::query()->create($validated);

        if ($request->has('general')) {
            GeneralDiscount::create([
                'fk_discount' => $inserted->id,
            ]);
        }

        foreach ($validated['applicable'] ?? [] as $id) {
            ApplicableDiscount::query()->create([
                'fk_discount' => $inserted->id,
                'fk_product' => $id,
            ]);
        }

        return redirect('/discount');
    }

    public function disable(Discount $discount)
    {
        $discount->update(['disabled' => true]);

        return redirect('/discount')->with('message', 'Successfully disabled discount');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $products = Product::all();

        return view('discount.edit')
            ->with('discount', $discount)
            ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $type = $request->input('type');

        if ($type === 'absolute') {
            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('discounts')
                        ->where('disabled', '=', false)
                        ->ignore($discount),
                ],
                'applicable' => ['nullable', 'array'],
                'type' => ['required', 'in:absolute,percentage'],
                'value' => ['required', 'numeric'],
            ]);

            $validated['absolute_discount'] = $validated['value'];
        } else if ($type === 'percentage') {
            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('discounts')
                        ->where('disabled', '=', false)
                        ->ignore($discount),
                ],
                'applicable' => ['nullable', 'array'],
                'type' => ['required', 'in:absolute,percentage'],
                'value' => ['required', 'numeric', 'min:1', 'max:100'],
            ]);

            $validated['percentage_discount'] = $validated['value'];
        } else {
            return back();
        }

        if ($validated['name'] === $discount->name && (int) $validated['value'] !== $discount->getValue()) {
            $discount->update(['disabled' => true]);

            ApplicableDiscount::query()
                ->where('fk_discount', '=', $discount->id)
                ->delete();

            $inserted = Discount::create($validated);

            if ($request->has('general')) {
                GeneralDiscount::createNotExists($inserted->id);
            } else {
                GeneralDiscount::query()
                    ->where('fk_discount', '=', $discount->id)
                    ->delete();
            }

            foreach ($validated['applicable'] ?? [] as $id) {
                ApplicableDiscount::query()->create([
                    'fk_discount' => $inserted->id,
                    'fk_product' => $id,
                ]);
            }
        } else {
            $discount->update($validated);

            if ($request->has('general')) {
                GeneralDiscount::createNotExists($discount->id);
            } else {
                GeneralDiscount::query()
                    ->where('fk_discount', '=', $discount->id)
                    ->delete();
            }

            ApplicableDiscount::query()
                ->where('fk_discount', '=', $discount->id)
                ->delete();

            foreach ($validated['applicable'] ?? [] as $id) {
                ApplicableDiscount::query()->create([
                    'fk_discount' => $discount->id,
                    'fk_product' => $id,
                ]);
            }
        }

        return redirect('/discount')->with('message', 'Successfully updated discount');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
    }
}
