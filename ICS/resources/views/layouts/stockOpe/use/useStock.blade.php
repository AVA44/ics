@extends('template.app')

@section('title', '入庫景品選択')
@section('pageCss', '')
@section('pageJs')
    <script src="{{ mix('js/useStockAjax.js') }}"></script>
    <script src="{{ mix('js/useStock.js') }}"></script>
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

    <!-- 景品選択-->
    <form method="post" action="#">
        <table class="inventories_table" border>
            <tr>
                <th>名前</th>
                <th>カテゴリ</th>
                <th>在庫</th>
                <th>選択</th>
            </tr>
            @foreach ($inventories as $inventory)

                <tr class="tableData">
                    <input type="hidden" value="{{ $inventory->id }}" />
                    <td>{{ $inventory->name }}</td>
                    <td>{{ $inventory->category_name }}</td>
                    <td>{{ $inventory->stocks }}</td>
                    <td><input class="choice" type="button" value="選択" /></td>
                </tr>
            @endforeach
        </table>
        <input type="button" value="確認" />
    </form>

@endsection
