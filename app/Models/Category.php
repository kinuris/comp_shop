<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['category'];

    static function fromProduct(int $pid): Category|null {
        $product = Product::query()->find($pid);

        if ($product === null) {
            return null;
        }

        return Category::query()->find($product->fk_category);
    }
}
