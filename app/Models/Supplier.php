<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'company_name',
    ];

    function getProductCategoriesSold(): array
    {
        $collection = Product::query()->where('fk_supplier', '=', $this->id)
            ->get('fk_category');

        $categoryIds = array();
        foreach ($collection as $item) {
            if (in_array($item->fk_category, $categoryIds)) {
                continue;
            }

            array_push($categoryIds, $item->fk_category);
        }

        return $categoryIds;
    }
}
