@extends('template.app')

@section('title', '削除ページ')

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
        <form method="post" action="{{ route('inventory.destroy') }}">
            @csrf
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
                        <td>{{ $inventory->name }}</td>
                        <td>{{ $inventory->category_name }}</td>
                        <td>{{ $inventory->unit_price }}</td>
                        <td>{{ $inventory->lank }}</td>
                        <td>{{ $inventory->expired_at }}</td>
                        <td>{{ $limited_at }}</td>
                        <td>{{ $limit_count }}</td>
                        <td><input type="checkbox" name="destroy[]" value="{{ $inventory->id }}"/></td>
                    </tr>
                @endforeach
            </table>
            <input type="submit" value="削除" />
        </form>
    </div>

@endsection
