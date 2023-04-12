@extends('template.app')

@section('title', '商品詳細')
@section('pageCss', '')

@section('content')

    <h2 id="show_top">{{ $inventory->name }}</h2>

    <!-- 賞味期限ごとの在庫 -->
    <div id="show_container">
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
        <div id="show_data_container">
            <div id="show_data_field">
                <div id="show_data">
                    <div class="show_datum">
                        <p class="show_datum_title">カテゴリ</p>
                        <span>　：　</span>
                        <p class="show_datum_value">{{ $inventory->category_name }}</p>
                    </div>
                    <div class="show_datum">
                        <p class="show_datum_title">１箱の値段</p>
                        <span>　：　</span>
                        <p class="show_datum_value">{{ $inventory->box_price }}</p>
                    </div>
                    <div class="show_datum">
                        <p class="show_datum_title">１箱の入数</p>
                        <span>　：　</span>
                        <p class="show_datum_value">{{ $inventory->parchase }}</p>
                    </div>
                    <div class="show_datum">
                        <p class="show_datum_title">単価</p>
                        <span>　：　</span>
                        <p class="show_datum_value">{{ $inventory->unit_price }}</p>
                    </div>
                    <div class="show_datum">
                        <p class="show_datum_title">ランク</p>
                        <span>　：　</span>
                        <p class="show_datum_value">{{ $inventory->lank }}</p>
                    </div>
                </div>
            </div>
            
            <!-- 画像のプレビュー -->
            <div id="preview_field">

                <!-- 画像を登録している時表示 -->
                @if ($inventory->image_url != "")
                    <img class="show_img_preview" src="data:image/png;base64,{{ $inventory->image_url }}">

                <!-- 登録していない時非表示 -->
                @else
                    <p>画像なし</p>
                @endif

            </div>
        </div>
    </div>
@endsection
