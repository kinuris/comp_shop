<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicableDiscount extends Model
{
    use HasFactory;

    protected $table = 'applicable_discounts';
    protected $fillable = [
        'fk_product',
        'fk_discount',
    ];


    // TODO: Fix
    // static public function able(): array
    // {
    //     $applicables = ApplicableDiscount::all();
    //     $able = array();
    //
    //     foreach ($applicables as $applicable) {
    //         $discount = Discount::query()->find($applicable->fk_product);
    //
    //         if (!$discount->disabled) {
    //             array_push($able, $applicable);
    //         }
    //     }
    //
    //     return $able;
    // }

    static public function able(): Builder
    {
        $abled = Discount::query()
            ->where('disabled', '=', false)
            ->select(['id'])
            ->get()
            ->toArray();

        $abled = array_map(fn ($apd) => $apd['id'], $abled);

        return ApplicableDiscount::query()->whereIn('fk_discount', $abled);
    }
}
