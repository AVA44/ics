<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\StockData;
use App\Stock;

class StockDataController extends Controller
{
    // 入庫する在庫入力
    public function addStockForm() {

        // 景品ごとの味取得
        $stocks_count = StockData::select('inventory_id')->latest('inventory_id')->first()->inventory_id;
        for ($i = 1; $i <= $stocks_count; $i++) {

            $stocks_data = StockData::whereInventory_id($i)->distinct()->select('taste_name')->get()->toArray();
            for ($l = 0; $l < count($stocks_data); $l++) {

                $taste[$i][] = $stocks_data[$l]['taste_name'];
            }
        }


        $inventories = Inventory::with('stocks_data')->get();
        $inventoryController = app()->make('App\Http\Controllers\InventoryController');
        $categories = $inventoryController->getCategory($inventories);

        return view('layouts.stockOpe.add.addStock', compact('inventories', 'categories', 'taste'));
    }

    // 処理->確認
    public function addStock(Request $request) {

        $stocks_data = StockData::all();

        for ($i = 0; $i < count($request->inventory_id); $i++) {

            // taste_name振り分け
            // 新しい味の時
            if ($request->taste_name[$i] == 'new') {

                $taste= $request->new_taste_name[$i];
            } else {
            // すでにある味の時

                $taste = $request->taste_name[$i];
            }

            // limited_at作成 賞味期限の４５日前
            $limited_at = date('Y-m-d', strtotime("{$request->expired_at[$i]} -45 day"));

            // 新しく在庫の情報を追加するか、在庫の加算だけするか分岐
            $update_if = StockData::whereInventory_id($request->inventory_id)->whereTaste_name($taste)->whereExpired_at($request->expired_at[$i])->first();

            // 在庫の加算だけの場合
            if (isset($update_if)) {

                // 在庫加算
                $stock_if = Stock::whereId($update_if->stock_data_id)->first();
                $stock_if->update([
                    'stock' => ($stock_if->stock) + ($request->stock[$i])
                ]);

                // 確認画面で使用
                $name_conf[] = Inventory::select('name')->whereid($request->inventory_id)->get()[0]->name;
                $expired_at_conf[] = $request->expired_at[$i];
                $limited_at_conf[] = $limited_at;
                $taste_name_conf[] = $taste;
                $stock_conf[] = $stock_if->stock;
            } else {
            // 新しく在庫の情報を追加する場合

                if ($request->stock[$i] != 0) {
                    $stock = Stock::create([
                        'stock' => $request->stock[$i]
                    ]);
                    $stock_data_id = Stock::select('id')->max('id');
                }

                // 紐付け用のstock_data_id取得
                $inventory = StockData::create([
                    'inventory_id' => $request->inventory_id[$i],
                    'stock_data_id' => $stock_data_id,
                    'expired_at' => $request->expired_at[$i],
                    'limited_at' => $limited_at,
                    'taste_name' => $taste
                ]);

                // 確認画面で使用
                $name_conf[] = Inventory::select('name')->whereid($request->inventory_id)->get()[0]->name;
                $expired_at_conf[] = $request->expired_at[$i];
                $limited_at_conf[] = $limited_at;
                $taste_name_conf[] = $taste;
                $stock_conf[] = $stock->stock;

            }
        }

        return view('layouts.stockOpe.add.addStockConfirm', compact('name_conf', 'expired_at_conf', 'limited_at_conf', 'taste_name_conf', 'stock_conf'));
    }

    // 出庫する在庫入力
    public function useStockForm() {

        // 景品の情報とその景品の在庫の情報をInventoryのidごとに取得
        for ($i = 1; $i <= Inventory::count(); $i++) {
            $choice_inventories[$i]= Inventory::whereId($i)->get();
            $choice_stocks[$i] = StockData::whereInventory_id($i)->orderBy('income_count', 'asc')->get();

            // 納品時の塊ごとにレコードの数とstockの合計取得
            $inventoryController = app()->make('App\Http\Controllers\InventoryController');
            $stocks_data = $inventoryController->getStock_dataDelimiter($choice_stocks[$i]);

            // limit_count 作成
            foreach ($choice_stocks[$i] as $stock) {
                $stock['limit_count'] = $inventoryController->getLimit_count($stock['limited_at']);
            }
        }

        // 景品情報とカテゴリーを重複削除して取得
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
