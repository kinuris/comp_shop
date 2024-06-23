<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $start = request()->query('start') ?? 'yesterday';
        $end = request()->query('end') ?? 'now';

        $start = date_create($start);
        $end = date_create($end);

        $transactions = PaymentTransaction::query()
            ->where('created_at', '>', $start)
            ->where('created_at', '<', $end)
            ->get();

        if (Auth::user()->isManager()) {
            return view('manager', compact('start', 'end', 'transactions'));
        }

        if (Auth::user()->isAdmin()) {
            return view('admin', compact('start', 'end', 'transactions'));
        }

        return view('product-search');
    }
}
