@extends('template.app')

@section('title', '商品詳細')
@section('pageCss', '')

@section('content')

    <h2 id="show_top">商品名</h2>

    <!-- 賞味期限ごとの在庫 -->
    <table id="show_table">
        <tr>
            <th>賞味期限</th>
            <th>使用期限</th>
            <th>残り日数</th>
            <th>在庫</th>
        </tr>
        <tr>
            <td>expired_at</td>
            <td>limited_at</td>
            <td>limit_count</td>
            <td>stock</td>
        </tr>
    </table>

    <!-- 商品の情報 -->
    <div id="show_data">
        <p>カテゴリ：</p>
        <p>１箱の値段：</p>
        <p>１箱の入り数：</p>
        <p>単価：</p>
        <p>ランク：</p>
        <p>画像：</p>
    </div>
@endsection
