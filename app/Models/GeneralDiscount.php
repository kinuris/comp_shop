<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralDiscount extends Model
{
    use HasFactory;

    protected $table = 'general_discounts';
    protected $fillable = [
        'fk_discount'
    ];

    static function createNotExists(int $id)
    {
        if (GeneralDiscount::query()->where('fk_discount', '=', $id)->first()) {
            return;
        }

        GeneralDiscount::create([
            'fk_discount' => $id,
        ]);
    }
}
