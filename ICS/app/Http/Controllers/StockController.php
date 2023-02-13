<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Stock;

class StockController extends Controller
{
    // 入庫する在庫入力
    public function addStockForm() {

        // 景品ごとの味の種類取得
        $stocks_count = Stock::select('inventory_id')->latest('inventory_id')->first()->inventory_id;
        for ($i = 1; $i <= $stocks_count; $i++) {
            $stocks = Stock::whereInventory_id($i)->distinct()->select('taste_name')->get()->toArray();
            for ($l = 0; $l < count($stocks); $l++) {

                $taste[$i][] = $stocks[$l]['taste_name'];
            }
        }
        $inventories = Inventory::with('stocks')->get();
        $inventoryController = app()->make('App\Http\Controllers\InventoryController');
        $categories = $inventoryController->getCategory($inventories);

        foreach ($inventories as $key => $inventory) {

            // 在庫の合計算出
            // 在庫あり
            $value = 0;
            if (count($inventory['stocks']) > 0) {

                foreach ($inventory['stocks'] as $stocks) {
                    $value += $stocks['stock'];
                }
                $inventory['stocks'] = $value;

            // 在庫なし
            } else {

                $inventory['stocks'] = '在庫なし';
            }
        }

        return view('layouts.stockOpe.add.addStock', compact('inventories', 'categories', 'taste'));
    }

    // 処理->確認
    public function addStock(Request $request) {

        $stocks = Stock::all();
        $income_count = Stock::select('income_count')->latest('income_count')->first()->income_count + 1;


        for ($i = 0; $i < count($request->inventory_id); $i++) {
            // dd($request->taste_name);
            if ($request->taste_name[$i] == 'new') {
                $taste= $request->new_taste_name[$i];
            } else {
                $taste = $request->taste_name[$i];
            }

            $limited_at = date('Y-m-d', strtotime("{$request->expired_at[$i]} -45 day"));

            $inventory = Stock::create([
                'inventory_id' => $request->inventory_id[$i],
                'income_count' => $income_count,
                'expired_at' => $request->expired_at[$i],
                'limited_at' => $limited_at,
                'taste_name' => $taste,
                'stock' => $request->stock[$i]
            ]);

            $name[] = Inventory::select('name')->whereid($request->inventory_id)->get()[0]->name;
            $expired_at[] = $request->expired_at[$i];
            $limited_at_conf[] = $limited_at;
            $taste_name[] = $taste;
            $stock[] = $request->stock[$i];

        }

        return view('layouts.stockOpe.add.addStockConfirm', compact('name', 'expired_at', 'limited_at_conf', 'taste_name', 'stock'));
    }

    // 出庫する在庫入力
    public function useStockForm() {

        $inventories = Inventory::with('stocks')->get();
        $inventoryController = app()->make('App\Http\Controllers\InventoryController');
        $categories = $inventoryController->getCategory($inventories);

        $empty = array();
        foreach ($inventories as $key => $inventory) {

            // 在庫の合計算出
            // 在庫あり
            $value = 0;
            if (count($inventory['stocks']) > 0) {

                foreach ($inventory['stocks'] as $stocks) {

                    $value += $stocks['stock'];
                }
                $inventory['stocks'] = $value;

            // 在庫なし
            } else {

                unset($inventories[$key]);
            }
        }

        return view('layouts.stockOpe.use.useStock', compact('inventories', 'categories'));
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
