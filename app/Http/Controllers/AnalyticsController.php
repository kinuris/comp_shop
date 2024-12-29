<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function summary() {
        $products = Product::query();

        if (request()->query('stat_sort') === 'acs') {
            $products = $products->orderBy('stock_quantity', 'desc');
        } elseif (request()->query('stat_sort') === 'desc') {
            $products = $products->orderBy('stock_quantity', 'asc');
        }

        $products = $products->get();

        return view('analytics.summary')->with('products', $products);
    }
}
