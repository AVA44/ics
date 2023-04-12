<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\StockData;
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
            $orderData = Inventory::with('stocks_data')
                ->where([
                    ['name', 'LIKE', '%'.$orderName.'%'],
                    ['category_name', '=', $orderCategory],
                ])
                ->get();

        // 名前検索
        } elseif ($orderName = $request->name_search) {
            $orderData = Inventory::with('stocks_data')
                ->where('name', 'LIKE', '%'.$orderName.'%')
                ->get();

        // カテゴリ検索
        } elseif ($orderCategory = $request->cate_search) {
            $orderData = Inventory::with('stocks_data')
                ->whereCategory_name($orderCategory)
                ->get();

        // 検索なし
        } else {
            $orderData = Inventory::with('stocks_data')
                ->get();
        }

        // データのトリミング、配列に格納
        $i = 0;
        foreach ($orderData as $orderDatum) {

            // Inventoryデータ格納
            $orderInventoryData[] = $orderDatum;

            // 在庫がある場合
            if (count($orderDatum['stocks_data']) > 0) {

                // Stockデータから最も早いexpired_atを取得して格納
                $expired_at = array();
                foreach ($orderDatum['stocks_data'] as $stocksData) {
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

            // 不要なstocks_dataを削除
            unset($orderDatum['stocks_data']);
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

            $stocks = StockData::where('inventory_id', '=', $inventory->id)->get();
            if (count($stocks) > 0) {
                foreach ($stocks as $stock) {
                    $value[] = $stock->expired_at;
                }
            } else {
                $value = array();
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

        // カテゴリ名が新しいものか既存のものかで振り分け
        // 新しいもの
        if ($request->category_name == 'new_category') {
            $category = $request->new_category_name;

        // 既存のもの
        } else {
            $category = $request->category_name;
        }
        dd($category);
        $unit_price = floor($request->box_price / $request->parchase);
        $lank = $this->getLank($unit_price);
        if ($request->image_url != '') {
            $image_url = base64_encode(file_get_contents($request->image_url->getRealPath()));
        } else {
            $image_url = "";
        }

        $inventory = Inventory::create([
            'name' => $request->name,
            'category_name' => $category,
            'parchase' => $request->parchase,
            'box_price' => $request->box_price,
            'unit_price' => $unit_price,
            'lank' => $lank,
            'image_url' => $image_url
        ]);

        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 景品の情報と在庫の情報を取得
        $inventory = Inventory::whereId($id)->first();
        $stocks_data = StockData::whereInventory_id($id)->orderBy('stock_id', 'asc')->get();

        // stockをstock_idごとに取得
        $stocks_id_unique_count = StockData::whereInventory_id($id)->select('stock_id')->distinct()->get();

        for ($i = 0; $i < count($stocks_id_unique_count); $i++) {

                $stocks[$stocks_id_unique_count[$i]['stock_id']] = Stock::whereId($stocks_id_unique_count[$i]['stock_id'])->orderBy('id', 'asc')->get();
        }

        // stocks_dataを表示する際stockとずれなく表示するための区切り取得
        $stocks_delimiter = $this->getStock_dataDelimiter($stocks_data);

        // limit_count 作成
        foreach ($stocks_data as $stock) {
            $stock['limit_count'] = $this->getLimit_count($stock['limited_at']);
        }

        return view('layouts.inventoryOpe.show', compact('inventory', 'stocks', 'stocks_data', 'stocks_delimiter', 'stocks_id_unique_count'));
    }

    public function destroyForm()
    {
        $inventories = Inventory::all();
        $categories = $this->getCategory($inventories);

        //各景品の一番早いexpired_atを取得
        $i = 0;
        foreach($inventories as $inventory) {

            $stocks = StockData::where('inventory_id', '=', $inventory->id)->get();
            if (count($stocks) > 0) {
                foreach ($stocks as $stock) {
                    $value[] = $stock->expired_at;
                }
            } else {
                $value = array();
            }
            if (count($value) >= 1) {
                $inventories[$i]['expired_at'] = min($value);
            } else {
                $inventories[$i]['expired_at'] =  '////';
            }
            $value = array();
            $i++;
        }

        return view('layouts.inventoryOpe.destroy', compact('inventories', 'categories'));
    }

    public function destroy(Request $request)
    {
        $des_inventory_id = $request->destroy;

        // Inventory削除
        for ($i = 0; $i < count($des_inventory_id); $i++) {
            Inventory::destroy($des_inventory_id[$i]);
        }

        return redirect()->route('inventory.index');
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
                $lank = 'noLank';
                break;
        };

        return $lank;
    }

    public function getLimited_at($expired_at) {

        $limited_at = date('Y-m-d', strtotime("$expired_at -45 day"));

        return $limited_at;
    }

    // stock_idごとに分けるための区切り取得
    public function getStock_dataDelimiter($stocks) {

        // stock_idで分ける
        $check = [];
        for ($i = 0; $i < count($stocks); $i++) {

            $stock_id = $stocks[$i]['stock_id'];

            // rowspan=>テーブルレイアウトで表示する際に使用
            // count=>rowspanを設定する<td>を指定する際に使用
            // 初めて出るstock_idの時
            if (!array_key_exists($stock_id, $check)) {
                $check[$stock_id]['rowspan'] = 1;
                $check[$stock_id]['count'] = $i;
            } else {
            // すでに出たstock_idの時
                $check[$stock_id]['rowspan']++;
            }
        }

        return $check;
    }

    // limit_count 所定の計算をして取得
    public function getLimit_count($int) {

        $value = (strtotime($int) - strtotime(date('Y-m-d'))) / 86400;

        return $value;
    }
}
