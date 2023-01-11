@extends('template.app')

@section('title', '商品詳細')
@section('pageCss', '')

@section('content')

    <h2 id="show_top">{{ $inventory->name }}</h2>

    <!-- 賞味期限ごとの在庫 -->
    <table id="show_table" border='1'>
        <tr>
            <th>賞味期限</th>
            <th>使用期限</th>
            <th>残り日数</th>
            <th>在庫</th>
        </tr>
        <!-- if (count($stocks) >= 1) { -->
            <!-- 在庫あり -->

        <!-- } else { -->
            <!-- 在庫なし -->
        <!-- } -->
    </table>

    <!-- 商品の情報 -->
    <div id="show_data">
        <p>カテゴリ：{{ $inventory->category_name }}</p>
        <p>１箱の値段：{{ $inventory->box_price }}</p>
        <p>１箱の入り数：{{ $inventory->parchase }}</p>
        <p>単価：{{ $inventory->unit_price }}</p>
        <p>ランク：{{ $inventory->lank }}</p>
        <p>画像：{{ $inventory->image_url }}</p>
    </div>
@endsection
