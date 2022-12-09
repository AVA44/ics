@extends('template.app')

@section('title', '一覧')
@section('pageCss', '')

@section('content')

    <h2 id="index_top">お菓子在庫一覧</h3>

    <!-- 景品検索・ソート -->
    <div id="order_froms">
        <form class="search"></form>
        <form class="sort"></form>
    </div>

    <!-- 景品一覧 -->
    <div id="inventories">
        <table class="inventories_table">
            <tr>
                <th>景品名</th>
                <th>カテゴリ</th>
                <th>単価</th>
                <th>賞味期限</th>
                <th>使用期限</th>
                <th>残り日数</th>
            </tr>
            <tr>
                <td>name</td>
                <td>category</td>
                <td>unit_price</td>
                <td>expired_at</td>
                <td>limited_at</td>
                <td>limit_count</td>
            </tr>
        </table>
    </div>
@endsection
