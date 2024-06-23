<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'barcode',
        'image_link',
        'fk_category',
        'fk_supplier',
        'stock_quantity',
        'price',
        'available',
        'description',
    ];

    function getApplicableDiscounts(): Collection
    {
        return ApplicableDiscount::query()->where('fk_product', '=', $this->id)
            ->get();
    }

    function getSnapshots(): Collection
    {
        return ProductSnapshot::allOf($this->id);
    }

    static function getSalesHistory()
    {
        // TODO:
    }
}
