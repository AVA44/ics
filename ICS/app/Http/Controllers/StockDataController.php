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

            // すでにある味の時
            } else {
                $taste = $request->taste_name[$i];
            }

            // limited_at作成 賞味期限の４５日前
            $limited_at = date('Y-m-d', strtotime("{$request->expired_at[$i]} -45 day"));

            // 同じ景品、味、賞味期限のものがある場合、ない場合で分岐
            $update_if = StockData::whereInventory_id($request->inventory_id)->whereTaste_name($taste)->whereExpired_at($request->expired_at[$i])->first();

            // ある場合 在庫加算
            if (isset($update_if)) {

                // 在庫加算
                $stock_if = Stock::whereId($update_if->stock_id)->first();
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
            // ない場合　在庫情報新規作成

                // 紐付け用のstock_id取得
                if ($request->stock[$i] != 0) {
                    $stock = Stock::create([
                        'inventory_id' => $request->inventory_id[$i],
                        'stock' => $request->stock[$i]
                    ]);
                    $stock_id = Stock::select('id')->max('id');
                }

                // レコード作成
                $inventory = StockData::create([
                    'inventory_id' => $request->inventory_id[$i],
                    'stock_id' => $stock_id,
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
        $inventoryController = app()->make('App\Http\Controllers\InventoryController');

        // idごとのInventory情報
        $inventories = Inventory::all();

        // 全カテゴリ
        $categories = $inventoryController->getCategory($inventories);

        // inventory_idごとのStockData情報
        for ($i = 0; $i < count($inventories); $i++) {
            $stocks_data[] = StockData::whereInventory_id($inventories[$i]['id'])
            ->orderBy('stock_id', 'asc')
            ->get();

        // inventory_idごとのstock情報をidごとに分けた情報
            for ($l = 0; $l < count($stocks_data[$i]); $l++) {
                $stocks[$i][$stocks_data[$i][$l]['stock_id']] =
                    Stock::whereInventory_id($inventories[$i]['id'])
                        ->whereId($stocks_data[$i][$l]['stock_id'])
                        ->get();
            }
        }

        // 選択肢側に使う情報([]は作成済)
        // [$inventories], $expired_at, $limited_at, $stockSum

        // 在庫のない景品情報削除
        // $exist_stock_numに含まれない数字をidにもつinventoryデータ, データの入ってないstocks_dataを削除
        // $exist_stock_num作成
        $exist_stock_num = [];
        foreach ($stocks as $stock) {
            foreach($stock as $stock_value) {
                if (!in_array($stock_value[0]['inventory_id'], $exist_stock_num)) {
                    $exist_stock_num[] = $stock_value[0]['inventory_id'];
                }
            }
        }

        // 該当するinventoryデータ削除
        $inventories_count = count($inventories);
        for ($i = 0; $i < $inventories_count; $i++) {
            if (!in_array($inventories[$i]['id'], $exist_stock_num)) {
                unset($inventories[$i]);
            }
        }

        // 該当するstocks_dataデータを削除
        $i = 0;
        foreach ($stocks_data as $stockData) {
            if (empty($stockData[0])) {
                unset($stocks_data[$i]);
            }
            $i++;
        }

        // 景品ごとの一番早い賞味期限とその使用期限
        for ($i = 0; $i < count($stocks_data); $i++) {
            if (isset($stocks_data[$i])) {

                // 配列リセット
                $expired_at_all = array();
                $limited_at_all = array();

                // 景品ごとの賞味期限と使用期限を配列に追加
                for ($l = 0; $l < count($stocks_data[$i]); $l++) {
                    $expired_at_all[] = $stocks_data[$i][$l]['expired_at'];
                    $limited_at_all[] = $stocks_data[$i][$l]['limited_at'];
                };

                // 景品ごとの一番早い賞味期限と使用期限を配列に追加
                if (isset($expired_at_all)) {
                    $expired_at[$i] = min($expired_at_all);
                    $limited_at[$i] = min($limited_at_all);
                } else {
                    $expired_at[$i] = "////";
                    $limited_at[$i] = "////";
                }
            }
        }

        // 景品ごとの在庫の合計一覧
        $inventory_keys = array_keys($inventories->toArray());
        $stockSum = [];
        $i = 0;
        foreach ($stocks as $stock) {
            foreach ($stock as $stock_value) {
                // 景品ごとに在庫加算
                // ひとつめ
                if (empty($stockSum[$inventory_keys[$i]])) {
                    $stockSum[$inventory_keys[$i]] = $stock_value[0]['stock'];

                // ふたつめ以降
                } else {
                    $stockSum[$inventory_keys[$i]] += $stock_value[0]['stock'];
                };
            };
            $i++;
        }

        // 選択されたものの表示に使う情報([]は作成済)
        // [$inventories], [$stocks_data], [$stocks], $stocks_data_delimiters
        for ($i = 0; $i < count($stocks_data); $i++) {
            if (isset($stocks_data[$i])) {
                $stocks_data_delimiters[$i] = $inventoryController->getStock_dataDelimiter($stocks_data[$i]);
            }
        }

        return view('layouts.stockOpe.use.useStock', compact('inventories', 'stocks_data', 'stocks', 'categories', 'expired_at', 'limited_at', 'stockSum', 'stocks_data_delimiters'));
    }

    // 処理->確認
    public function useStock(Request $request) {

        // formの値格納
        $inventory_id = $request->inventory_id;
        $stock_id = $request->stock_id;
        $use_stock = $request->use_stock;
        $expired_at = $request->expired_at;
        $limited_at = $request->limited_at;

        // 余分なデータ削除
        $unset_data_keys = array_keys($use_stock, 0);
        for ($i = 0; $i < count($unset_data_keys); $i++) {
            unset($inventory_id[$unset_data_keys[$i]]);
            unset($stock_id[$unset_data_keys[$i]]);
            unset($use_stock[$unset_data_keys[$i]]);
            unset($expired_at[$unset_data_keys[$i]]);
            unset($limited_at[$unset_data_keys[$i]]);
        };

        // index振り直し
        $inventory_id = array_values($inventory_id);
        $stock_id = array_values($stock_id);
        $use_stock = array_values($use_stock);
        $expired_at_conf = array_values($expired_at);
        $limited_at_conf = array_values($limited_at);

        // 在庫が使用される場合
        if (count($inventory_id) > 0) {
            // use_stockの値を数値に変換
            for ($i = 0; $i < count($use_stock); $i++) {
                $use_stock[$i] = intval($use_stock[$i]);
            }

            for ($i = 0; $i < count($inventory_id); $i++) {

                // stock使用分を減算
                $stock = Stock::find($stock_id[$i]);
                $stock->update([
                    'stock' => ($stock->stock) - ($use_stock[$i])
                ]);

                // 在庫０のstock_dataとstockを削除
                if ($stock->stock <= 0) {
                    $del_sd = StockData::whereInventory_id($inventory_id[$i])->whereStock_id($stock_id[$i])->delete();
                    $del_s = Stock::find($stock_id[$i])->delete();

                    // dd($del_sd, $del_s);
                }

                // 確認画面用の景品名と減算後のストック数を取得
                $name_conf[] = Inventory::select('name')->find($inventory_id[$i])->name;
                $stock_conf[] = $stock->stock;
            }

            return view('layouts.stockOpe.use.useStockConfirm', compact('name_conf', 'expired_at_conf', 'limited_at_conf', 'stock_conf'));

        // 在庫が使用されない場合
        } else {
            $name_conf = array();
            $expired_at_conf = array();
            $limited_at_conf = array();
            $stock_conf = array();

            return view('layouts.stockOpe.use.useStockConfirm', compact('name_conf', 'expired_at_conf', 'limited_at_conf', 'stock_conf'));
        }
    }

    // 在庫の削除ページ
    public function destroyForm() {

        return vies('layouts.stockOpe.destroy.stockDestroy');
    }

    // 削除処理
    public function destroy() {

        return redirect()->route('inventory.index')
    }
}
