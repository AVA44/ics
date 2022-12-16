@extends('template.app')

@section('title', '出庫景品選択')
@section('pageCss', '')

@section('content')

    <h2>景品入庫</h2>

    <!-- 景品検索、ソート用のデータ入力する場所 -->
    <label for="search">名前検索：</label><input class="sort" name="search" type="text" />
    <select>
        <option>カテゴリ１</option>
        <option>カテゴリ２</option>
        <option>カテゴリ３</option>
        <option>カテゴリ４</option>
    </select>

    <!-- < -->
    <form method="post" action="#">
        <table>
            <tr>
                <th>選択</th>
                <th>名前</th>
                <th>カテゴリ</th>
            </tr>
            <tr>
                <td><input type="checkbox" value="1" /></td>
                <input type="hidden" value="景品ID" />
                <td>Inventory1</td>
                <td>Category1</td>
            </tr>
            <tr>
                <td><input type="checkbox" value="1" /></td>
                <input type="hidden" value="景品ID" />
                <td>Inventory2</td>
                <td>Category2</td>
            </tr>
            <tr>
                <td><input type="checkbox" value="1" /></td>
                <input type="hidden" value="景品ID" />
                <td>Inventory3</td>
                <td>Category3</td>
            </tr>
            <tr>
                <td><input type="checkbox" value="1" /></td>
                <input type="hidden" value="景品ID" />
                <td>Inventory4</td>
                <td>Category4</td>
            </tr>
        </table>
        <input type="button" value="景品入庫" onclick="getData()" />
    </form>

    <script>
    </script>

@endsection
