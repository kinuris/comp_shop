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
        $end = request()->query('end') ?? 'today';

        $start = date_create($start);
        $end = date_create($end)->setTime(23, 59, 59);

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

    public function summaryExport()
    {
        $products = Product::query()->get();

        $handle = fopen('php://output', 'w');

        $cb = function () use ($handle, $products) {
            fputcsv($handle, ['ID', 'Name', 'Cost (Original Price)', 'Retail Price', 'Wholesale Price', 'Current Stock', 'Status', 'Inventory Cost', 'Retail Value', 'Off Take Value']);
            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->product_name,
                    $product->original_price,
                    $product->price,
                    $product->wholesale_price ? $product->wholesale_price : 'N/A',
                    $product->stock_quantity,
                    $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock',
                    $product->original_price * $product->stock_quantity,
                    $product->price * $product->stock_quantity,
                    ($product->price * $product->stock_quantity) - ($product->original_price * $product->stock_quantity),
                ]);
            }
        };

        $fileName = date_create()->format('Y_m_d') . '_summary' . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response()->stream($cb, 200, $headers);
    }
}
