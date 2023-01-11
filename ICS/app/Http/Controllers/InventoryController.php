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
        if (($orderName = $request->name_search) && ($orderCategory = $request->cate_search)) {
            $orderData = Inventory::
                with('stocks')
                ->where([
                    ['name', '=', $orderName],
                    ['category_name', '=', $orderCategory],
                ])
                ->get();

        } elseif ($orderName = $request->name_search) {
            $orderData = Inventory::with('stocks')->whereName($orderName)->get();

        } elseif ($orderCategory = $request->cate_search) {
            $orderData = Inventory::with('stocks')->whereCategory_name($orderCategory)->get();

        } else {
            $orderData = Inventory::with('stocks')->get();
        }

        // データのトリミング、配列に格納
        $i = 0;
        foreach ($orderData as $orderDatum) {
            // Inventoryデータ格納
            $orderInventoryData[] = $orderDatum;
            // Stockデータから最も早いexpired_atを取得して格納
            $expired_at = array();
            foreach ($orderDatum['stocks'] as $stocksData) {
                $expired_at[$stocksData['limited_at']] = $stocksData['expired_at'];
            }
            $orderInventoryData[$i]['expired_at'] = min($expired_at);
            $orderInventoryData[$i]['limited_at'] = array_search($orderInventoryData[$i]['expired_at'], $expired_at);
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
        $inventory = Inventory::whereId($id)->first();
        return view('layouts.inventoryOpe.show', compact('inventory'));
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
}
