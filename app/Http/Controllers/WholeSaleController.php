<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WholeSaleController extends Controller
{
    public function index() {
        return view('wholesale.index');
    }
}
