<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Ramsey\Uuid\v4;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'fk_user',
        'fk_payment_method',
        'fk_discount',
    ];

    static function create(int $userId, int $methodId, ?int $discountId): PaymentTransaction
    {
        return PaymentTransaction::query()->create([
            'id' => v4(),
            'fk_user' => $userId,
            'fk_payment_method' => $methodId,
            'fk_discount' => $discountId,
        ]);
    }

    function getItems(): array
    {
        $entries = Cart::query()
            ->where('fk_payment_transaction', '=', $this->id)
            ->get();

        $pids = array();
        foreach ($entries as $entry) {
            array_push($pids, $entry->fk_product);
        }

        $pids = array_count_values($pids);

        return $pids;
    }

    function getDiscounts(): array
    {
        $entries = Cart::query()
            ->where('fk_payment_transaction', '=', $this->id)
            ->get();

        $discounts = [];
        foreach ($entries as $entry) {
            if ($entry->fk_discount !== null) {
                $discounts[$entry->fk_product] = $entry->fk_discount;
            }
        }

        return $discounts;
    }
}
