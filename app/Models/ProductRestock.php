<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRestock extends Model
{
    use HasFactory;

    protected $table = 'product_restocks';
    protected $fillable = [
        'fk_product',
        'fk_user',
        'amount',
    ];

    public function kind(): string
    {
        return 'restock';
    }

    public function isAdd(): bool
    {
        return $this->amount > 0;
    }

    public function product()
    {
        return Product::query()->find($this->fk_product);
    }
}
