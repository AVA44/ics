<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Stock;

class InventoryController extends Controller
{

    ////////////////////////////////
    // viewから呼び出して使うやつ
    ////////////////////////////////

    public function ajax(Request $request) {

        // 検索データ取得
        // 名前検索・カテゴリ検索
        if (($orderName = $request->name_search) && ($orderCategory = $request->cate_search)) {
            $orderData = Inventory::with('stocks')
                ->where([
                    ['name', 'LIKE', '%'.$orderName.'%'],
                    ['category_name', '=', $orderCategory],
                ])
                ->get();

        // 名前検索
        } elseif ($orderName = $request->name_search) {
            $orderData = Inventory::with('stocks')
                ->where('name', 'LIKE', '%'.$orderName.'%')
                ->get();

        // カテゴリ検索
        } elseif ($orderCategory = $request->cate_search) {
            $orderData = Inventory::with('stocks')
                ->whereCategory_name($orderCategory)
                ->get();

        // 検索なし
        } else {
            $orderData = Inventory::with('stocks')
                ->get();
        }

        // データのトリミング、配列に格納
        $i = 0;
        foreach ($orderData as $orderDatum) {

            // Inventoryデータ格納
            $orderInventoryData[] = $orderDatum;

            // 在庫がある場合
            if (count($orderDatum['stocks']) > 0) {

                // Stockデータから最も早いexpired_atを取得して格納
                $expired_at = array();
                foreach ($orderDatum['stocks'] as $stocksData) {
                    $expired_at[$stocksData['limited_at']] = $stocksData['expired_at'];
                };
                $orderInventoryData[$i]['expired_at'] = min($expired_at);

                // limited_at, limit_count作成
                $orderInventoryData[$i]['limited_at'] = array_search($orderInventoryData[$i]['expired_at'], $expired_at);
                $orderInventoryData[$i]['limit_count'] = $this->getLimit_count($orderInventoryData[$i]['limited_at']);

            // 在庫がない場合
            } else {
                $orderInventoryData[$i]['expired_at'] = "////";
                $orderInventoryData[$i]['limited_at'] = "////";
                $orderInventoryData[$i]['limit_count'] = "////";
            }

            // 不要なstocksデータを削除
            unset($orderDatum['stocks']);
            $i++;
        }

         return $orderInventoryData;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $inventories = Inventory::all();
        $categories = $this->getCategory($inventories);

        //各景品の一番早いexpired_atを取得
        $i = 0;
        foreach($inventories as $inventory) {

            $stocks = Stock::where('inventory_id', '=', $inventory->id)->get();
            foreach ($stocks as $stock) {
                $value[] = $stock->expired_at;
            }
            if (count($value) >= 1) {
                $inventories[$i]['expired_at'] = min($value);
            } else {
                $inventories[$i]['expired_at'] =  '////';
            }
            $value = array();
            $i++;
        }

        return view('layouts.inventoryOpe.index', compact('inventories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventories = Inventory::all();
        $categories = $this->getCategory($inventories);

        return view('layouts.inventoryOpe.create', compact('inventories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * name, category_name, parchase, box_price, unit_price, lank, taste_flag, image_url
     */
    public function store(Request $request)
    {
        $unit_price = floor($request->box_price / $request->parchase);
        $lank = $this->getLank($unit_price);
        $inventory = Inventory::create([
            'name' => $request->name,
            'category_name' => $request->category_name,
            'parchase' => $request->parchase,
            'box_price' => $request->box_price,
            'unit_price' => $unit_price,
            'lank' => $lank,
            'image_url' => $request->image_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 景品の情報とその景品の在庫の情報取得
        $inventory = Inventory::whereId($id)->first();
        $stocks = Stock::whereInventory_id($id)->orderBy('income_count', 'asc')->get();

        // 納品時の塊ごとにレコードの数とstockの合計取得
        $stocks_data = $this->getIncome_countCountandStockTotal($stocks);

        // limit_count 作成
        foreach ($stocks as $stock) {
            $stock['limit_count'] = $this->getLimit_count($stock['limited_at']);
        }
        
        return view('layouts.inventoryOpe.show', compact('inventory', 'stocks', 'stocks_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::whereId($id)->get();
        return view('layouts.inventoryOpe.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    ////////////////////////////////
    // コントローラー内で使うやつ
    ////////////////////////////////

    // category_name 重複カットして取得
    public function getCategory($inventories) {
        $categories = array();
        $tmpkey = array();

        foreach ($inventories as $inventory){
            if (!isset($tmpkey[$inventory->category_name])){
                $categories[] = $inventory->category_name;
                $tmpkey[$inventory->category_name] = "true";
            }
        }

        return $categories;
    }

    // lank 条件に則って作成
    public function getLank($unit_price) {

        switch ($unit_price) {
            case $unit_price >= 780:
                $lank = 'A';
                break;
            case $unit_price >= 680:
                $lank = 'B';
                break;
            case $unit_price >= 580:
                $lank = 'C';
                break;
            case $unit_price >= 400:
                $lank = 'D';
                break;
            case $unit_price >= 300:
                $lank = 'E';
                break;
            case $unit_price >= 100:
                $lank = 'F';
                break;
            default:
                $lank = '';
                break;
        };

        return $lank;
    }

    public function getLimited_at($expired_at) {

        $limited_at = date('Y-m-d', strtotime("$expired_at -45 day"));

        return $limited_at;
    }

    // income_count 重複をカウント
    public function getIncome_countCountandStockTotal($stocks) {

        $stocks_array = $stocks->toArray();

        $value = [];
        $i = 0;
        foreach ($stocks_array as $stocks_data) {
            $i++;
            if (array_key_exists($stocks_data['income_count'], $value)) {
                $value[$stocks_data['income_count']]['rowspan'] += 1;
                $value[$stocks_data['income_count']]['total'] += $stocks_data['stock'];
            } else {
                $value[$stocks_data['income_count']]['rowspan'] = 1;
                $value[$stocks_data['income_count']]['total'] = $stocks_data['stock'];
                $value[$stocks_data['income_count']]['count'] = $i;
            }
        };

        return $value;
    }

    // limit_count 所定の計算をして取得
    public function getLimit_countt($array) {

        foreach ($array as $data) {
            $value[] = (strtotime($data['limited_at']) - strtotime(date('Y-m-d'))) / 86400;
        };

        return $value;
    }

    public function getLimit_count($int) {

        $value = (strtotime($int) - strtotime(date('Y-m-d'))) / 86400;

        return $value;
    }
}
