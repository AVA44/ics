<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Stock;

class InventoryController extends Controller
{
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

        //各景品の一番早いexpired_atを取得
        $i = 0;
        foreach($inventories as $inventory) {

            $stocks = Stock::where('inventory_id', '=', $inventory->id)->get();
            foreach ($stocks as $stock) {
                $value[] = $stock->expired_at;
            }
            $inventories[$i]['expired_at'] = min($value);
            $value = array();
            $i++;
        }

        return view('layouts.inventoryOpe.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.inventoryOpe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('layouts.inventoryOpe.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('layouts.inventoryOpe.edit');
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
}
