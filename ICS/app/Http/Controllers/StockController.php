<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Stock;

class StockController extends Controller
{
    // 入庫する在庫入力
    public function addStockForm() {
        $inventories = Inventory::all();

        return view('layouts.stockOpe.add.addStock', compact('inventories'));
    }

    // 確認
    public function addStockConfilm() {
        return view('layouts.stockOpe.add.addStockConfilm');
    }

    // 処理
    public function addStock() {
    }

    // 出庫する在庫入力
    public function useStockForm() {
        return view('layouts.stockOpe.use.useStock');
    }

    // 確認
    public function useStockConfilm() {
        return view('layouts.stockOpe.use.useStockConfilm');
    }

    // 処理
    public function useStock() {

    }

    // 在庫選択削除
    public function choiceStockDestroy() {
        return view('layouts.stockOpe.destroy.stockDestroy');
    }

    // 在庫まとめて削除
    public function absentStockDestroy() {

    }
}
