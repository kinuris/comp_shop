<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;

class PaymentTransactionController extends Controller
{
    public function html_generate_modal(PaymentTransaction $transaction)
    {
        $html = view('layouts.receipt-modal')
            ->with('transaction', $transaction)
            ->render();

        return response(content: $html)
            ->header('Content-Type', 'text/plain');
    }
}
