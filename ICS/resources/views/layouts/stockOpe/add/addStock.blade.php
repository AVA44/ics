@extends('template.app')

@section('title', '入庫景品選択')
@section('pageCss', '')
@section('pageJs')
    <script src="{{ mix('js/addStockAjax.js') }}"></script>
    <script src="{{ mix('js/addStock.js') }}"></script>
@endsection

@section('content')

    <h2>景品入庫</h2>

    <!-- 景品検索・ソート -->
    @component('components.orderForm',
    [
        'inventories' => $inventories,
        'categories' => $categories
    ])
    @endcomponent

    <div id="addStockContainer" style="display: flex;">

        <!-- 景品選択 -->
        <div class="inventories_choice">
            <h4>景品選択</h4>
            <table class="inventories_table" border>
                <tr>
                    <th>名前</th>
                    <th>カテゴリ</th>
                    <th>選択</th>
                    <th>味追加</th>
                </tr>
                @foreach ($inventories as $inventory)
                    <tr class="tableData">
                        <td style="display: none">{{ $inventory->id }}</td>
                        <td>{{ $inventory->name }}</td>
                        <td>{{ $inventory->category_name }}</td>
                        <td><input class="choice_btn choice{{ $inventory->id }}" type="button" value="選択" /></td>
                        <td><input class="add_taste_btn add_taste{{ $inventory->id }}" type="button" value="味追加" disabled /></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <!-- 選択した景品確認 -->
        <div class="inventories_confirm">
            <h4>在庫を追加する景品</h4>
            <form class="addDataForm" method="post" action="{{ action('StockDataController@addStock') }}">
                @csrf
            </form>

        </div>

    </div>
    <input class="add" type="button" value="追加" />

    <!-- javascriptで呼び出して使う景品の味選択用セレクトタグ -->
    @for ($i = 1; $i <= count($taste); $i++)
        <div class="taste{{ $i }}" style="display: none;">
            <select class="select" name="taste_name[]">
                    <option value="new">新しい味</option>
                @if (isset($taste[$i]))
                    @for ($l = 0; $l < count($taste[$i]); $l++)
                        <option value="{{ $taste[$i][$l] }}">{{ $taste[$i][$l] }}</option>
                    @endfor
                @endif
            </select>
        </div>
    @endfor

<script>
window.Laravel = {};
window.Laravel.taste = @json($taste);
</script>
@endsection
