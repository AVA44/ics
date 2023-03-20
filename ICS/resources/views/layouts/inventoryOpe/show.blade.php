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


        @for ($i = 0; $i < count($stocks_data); $i++)
            <tr>
                <td>{{ $stocks_data[$i]->taste_name }}</th>
                <td>{{ $stocks_data[$i]->expired_at }}</th>
                <td>{{ $stocks_data[$i]->limited_at }}</th>
                <td>{{ $stocks_data[$i]->limit_count }}</th>
                    @if ($stocks_delimiter[$stocks_data[$i]['stock_id']]['count'] == $i)
                        <td rowspan="{{ $stocks_delimiter[$stocks_data[$i]['stock_id']]['rowspan'] }}">
                            {{ $stocks[$stocks_data[$i]['stock_id']][0]['stock'] }}
                        </td>
                    @endif
            </tr>
        @endfor
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
