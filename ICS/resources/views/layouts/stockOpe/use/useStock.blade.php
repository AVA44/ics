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
    <div class="useStock_container" style="display: flex">
        <div class="choice_field">
            <table class="inventories_table" border>
                <tr>
                    <th>名前</th>
                    <th>カテゴリ</th>
                    <th>一番早い賞味期限</th>
                    <th>←の在庫の使用期限</th>
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
                            <td><input class="choice" type="button" value="選択" /></td>
                        </tr>
                    @endif
                @endfor
            </table>
        </div>

        <form class="useDataForm" method="post" action="{{ action('StockDataController@useStock') }}">
            @csrf
            <div class="form_field_head" style="display: flex;">
                <h4 class="field_head_name">景品名</h4>
                <table border="1">
                    <tr>
                        <td>賞味期限</td>
                        <td>使用期限</td>
                        <td>在庫</td>
                        <td>使用数</td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <div><input class="use" type="button" value="登録" /></div>

    <div class="choice_field_material" style="display:none">
        @for ($i = 0; $i < count($stocks_data); $i++)
            @if (isset($stocks_data[$i]))
                <div class="{{ $i + 1 }}">
                    <table border="1">
                        @for ($l = 0; $l < count($stocks_data[$i]); $l++)
                            <tr>
                                <input class="inventory_id" type="hidden" name="inventory_id[]" value="{{ $i + 1 }}" />
                                <input class="stock_id" type="hidden" name="stock_id[]" value="{{ $stocks_data[$i][$l]->stock_id }}" />
                                <input type="hidden" name="expired_at[]" value="{{ $stocks_data[$i][$l]->expired_at }}" />
                                <input type="hidden" name="limited_at[]" value="{{ $stocks_data[$i][$l]->limited_at }}" />
                                <td>{{ $stocks_data[$i][$l]->expired_at }}</td>
                                <td>{{ $stocks_data[$i][$l]->limited_at }}</td>
                                @if ($stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['count'] == $l)
                                    <td class="max" rowspan="{{ $stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['rowspan'] }}">
                                        {{ $stocks[$stocks_data[$i][$l]['inventory_id']-1][$stocks_data[$i][$l]['stock_id']][0]['stock'] }}
                                    </td>
                                    <td rowspan="{{ $stocks_data_delimiters[$i][$stocks_data[$i][$l]['stock_id']]['rowspan'] }}">
                                        <input class="use_stock" type="number" name="use_stock[]" min="1" max="{{ $stocks[$stocks_data[$i][$l]['inventory_id']-1][$stocks_data[$i][$l]['stock_id']][0]['stock'] }}" />
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

@endsection
