@extends('template.app')

@section('title', '商品詳細')
@section('pageCss', '')

@section('content')

    <h2 id="show_top">{{ $inventory->name }}</h2>

    <!-- 賞味期限ごとの在庫 -->
    <table id="show_table" border='1'>

        <tr>
            <th>味</th>
            <th>賞味期限</th>
            <th>使用期限</th>
            <th>残り日数</th>
            <th>在庫</th>
        </tr>

        @foreach ($stocks as $stock)
            <tr>
                <th>{{ $stock->taste_name }}</th>
                <th>{{ $stock->expired_at }}</th>
                <th>{{ $stock->limited_at }}</th>
                <th>{{ $limit_count[$loop->index] }}</th>
                @if ($stocks_data[$stock['income_count']]['count'] == $loop->iteration)
                    <th rowspan="{{ $stocks_data[$stock['income_count']]['rowspan'] }}">
                        {{ $stocks_data[$stock['income_count']]['total'] }}
                    </th>
                @endif
            </tr>
        @endforeach
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
