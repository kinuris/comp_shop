<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'fk_product',
        'fk_product_snapshot',
        'fk_payment_transaction',
        'fk_discount',
    ];
}
