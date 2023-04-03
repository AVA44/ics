@extends('template.app')

@section('title', '削除ページ')

@section('pageJs')
    <script src="{{ mix('js/destroy.js') }}"></script>
@endsection

@section('content')

    <h2 id="index_top">お菓子の情報削除</h3>

    <!-- 景品検索・ソート -->
    @component('components.orderForm',
    [
        'inventories' => $inventories,
        'categories' => $categories
    ])
    @endcomponent

    <!-- 景品一覧 -->
    <div id="inventories">
        <table class="inventories_table" border="1">
            <tr>
                <th>景品名</th>
                <th>カテゴリ</th>
                <th>単価</th>
                <th>ランク</th>
                <th>賞味期限</th>
                <th>使用期限</th>
                <th>残り日数</th>
                <th>削除</th>
            </tr>

            @foreach ($inventories as $inventory)
                @php

                    // $limited_at $limit_count作成
                    // 在庫がない場合
                    if ($inventory->expired_at == '////'){
                        $limited_at = '////';
                        $limit_count = '////';

                    // 在庫がある場合
                    } else {
                        $limited_at = date('Y-m-d', strtotime("$inventory->expired_at -45 day"));
                        $limit_count = (strtotime($limited_at) - strtotime(date('Y-m-d'))) / 86400;
                    };
                @endphp

                <tr class="tableData">
                    <input class="id" type="hidden" value="{{ $inventory->id }}" />
                    <td class="name">{{ $inventory->name }}</td>
                    <td class="category">{{ $inventory->category_name }}</td>
                    <td>{{ $inventory->unit_price }}</td>
                    <td>{{ $inventory->lank }}</td>
                    <td>{{ $inventory->expired_at }}</td>
                    <td>{{ $limited_at }}</td>
                    <td>{{ $limit_count }}</td>
                    <td><input class="destroy_choice desBtn{{ $inventory->id }}" type="button" value="選択" /></td>
                </tr>
            @endforeach
        </table>
        <input class="destroy_submit" type="button" value="削除" />
    </div>
    <div class="destroy_field"></div>
    <form class="destroy_form" method="post" action="{{ route('inventory.destroy') }}">
        @csrf
    </form>

@endsection
