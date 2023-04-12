@extends('template.app')

@section('title', '入庫景品選択')
@section('pageCss', '')
@section('pageJs')
    <script src="{{ mix('js/useStockAjax.js') }}"></script>
    <script src="{{ mix('js/useStock.js') }}"></script>
@endsection

@section('content')

    <h2>景品出庫</h2>

    <!-- 景品検索・ソート -->
    @component('components.orderForm',
    [
        'inventories' => $inventories,
        'categories' => $categories
    ])
    @endcomponent

    <!-- 景品選択-->
    <div id="useStockContainer">
        <div id="choice_field">
        <h3>景品選択</h3>
        <table id="inventories_table useStock_inventories_table" border>
            <tr>
                <th>名前</th>
                <th>カテゴリ</th>
                <th>賞味期限</th>
                <th>使用期限</th>
                <th>在庫の総数</th>
                <th>選択</th>
            </tr>
            @for ($i = 0; $i < count($inventories); $i++)
                @if (isset($inventories[$i]))
                    <tr class="tableData">
                        <input type="hidden" class="inventory_id" value="{{ $inventories[$i]->id }}" />
                        <td>{{ $inventories[$i]->name }}</td>
                        <td>{{ $inventories[$i]->category_name }}</td>
                        <td>{{ $expired_at[$i] }}</td>
                        <td>{{ $limited_at[$i] }}</td>
                        <td>{{ $stockSum[$i] }}</td>
                        <td><input class="choice choice{{ $inventories[$i]->id }}" type="button" value="選択" /></td>
                    </tr>
                @endif

            @endfor

        </table>
        </div>

        <!-- 選択した景品を表示、送信するためのフォーム -->
        <form id="useDataForm" method="post" action="{{ action('StockDataController@useStock') }}">
            @csrf
            <h3>使用する景品と使用</h3>
            <div id="form_field_top">
                <h4 id="form_field_top_name">景品名</h4>
                <table id="form_field_top_table" border="1">
                    <tr>
                        <td class="form_field_top_table_td">賞味期限</td>
                        <td class="form_field_top_table_td">使用期限</td>
                        <td class="form_field_top_table_td">在庫</td>
                        <td class="form_field_top_table_td">使用数</td>
                    </tr>
                </table>
                <p id="empty_box"></p>
            </div>
        </form>
    </div>
    <div><input class="use" type="button" value="登録" /></div>

    <!-- 景品を選択した時に表示する情報 javascriptで呼び出して使用 -->
    <div id="choice_field_material" style="display: none">
        @for ($i = 0; $i < count($stocks_data); $i++)
            @if (isset($stocks_data[$i]))
                <div class="{{ $stocks_data[$i][0]['inventory_id'] }}">
                    <table class="choice_field_table" border="1">
                        @for ($l = 0; $l < count($stocks_data[$i]); $l++)
                            <tr>
                                <input class="inventory_id" type="hidden" name="inventory_id[]" value="{{ $stocks_data[$i][0]['inventory_id'] }}" />
                                <input class="stock_id" type="hidden" name="stock_id[]" value="{{ $stocks_data[$i][$l]->stock_id }}" />
                                <input type="hidden" name="expired_at[]" value="{{ $stocks_data[$i][$l]->expired_at }}" />
                                <input type="hidden" name="limited_at[]" value="{{ $stocks_data[$i][$l]->limited_at }}" />
                                <td class="choice_field_table_td">{{ $stocks_data[$i][$l]->expired_at }}</td>
                                <td class="choice_field_table_td">{{ $stocks_data[$i][$l]->limited_at }}</td>
                                @if ($stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['count'] == $l)
                                    <td class="choice_field_table_td stock" rowspan="{{ $stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['rowspan'] }}">
                                        {{ $stocks[$stocks_data[$i][$l]['inventory_id']][$stocks_data[$i][$l]['stock_id']][0]['stock'] }}
                                    </td>
                                    <td class="choice_field_table_td" rowspan="{{ $stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['rowspan'] }}">
                                        <input class="use_stock" type="number" name="use_stock[]" min="1" max="{{ $stocks[$stocks_data[$i][$l]['inventory_id']][$stocks_data[$i][$l]['stock_id']][0]['stock'] }}" />
                                    </td>
                                @else
                                    <input type="hidden" name="use_stock[]" value="0" />
                                @endif

                            </tr>
                        @endfor

                    </table>
                </div>
            @endif

        @endfor

    </div>

    <!-- 景品検索時に使用する景品ごとの在庫の総数 -->
    <div id="stocks_total" style="display: none;">
        @for ($i = 0; $i < count($inventories); $i++)
            @if (isset($inventories[$i]))
                <p id="stock_total_{{ $inventories[$i]['id']}}">{{ $stockSum[$i] }}</p>
            @endif

        @endfor
        
    </div>

@endsection
