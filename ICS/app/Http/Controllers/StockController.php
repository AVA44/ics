<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function addStock() {
        return view('layouts.stockOpe.add.addStock');
    }

    public function addStockConfilm() {
        return view('layouts.stockOpe.add.addStockConfilm');
    }

    public function useStock() {
        return view('layouts.stockOpe.use.useStock');
    }

    public function useStockConfilm() {
        return view('layouts.stockOpe.use.useStockConfilm');
    }

    public function stockDestroy() {
        return view('layouts.stockOpe.destroy.stockDestroy');
    }
}
