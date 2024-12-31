<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function analytics()
    {
        $start = request()->query('start') ?? 'yesterday';
        $end = request()->query('end') ?? 'now';

        $start = date_create($start);
        $end = date_create($end);

        $transactions = PaymentTransaction::query()
            ->where('created_at', '>', $start)
            ->where('created_at', '<', $end)
            ->get();

        return view('manager')
            ->with('start', $start)
            ->with('end', $end)
            ->with('transactions', $transactions);
    }

    public function summary()
    {
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
