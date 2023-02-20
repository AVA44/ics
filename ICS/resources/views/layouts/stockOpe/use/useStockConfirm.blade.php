@extends('template.app')

@section('title', '景品出庫')
@section('pageCss', '')

@section('content')

    <h3>選択した景品</h3>

    <!-- useStock.blade.phpで選択した景品一覧と追加する情報入力フォーム -->
    <table>
        <tr>
            <th>名前</th>
            <th>カテゴリ</th>
            <th>賞味期限</th>
            <th>使用する個数</th>
        </tr>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品１</th>
                <th>カテゴリ１</th>
                <th>賞味期限</th>
                <th><input class="usestock" name="usestock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品2</th>
                <th>カテゴリ2</th>
                <th>賞味期限</th>
                <th><input class="usestock" name="usestock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品3</th>
                <th>カテゴリ3</th>
                <th>賞味期限</th>
                <th><input class="usestock" name="usestock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品4</th>
                <th>カテゴリ4</th>
                <th>賞味期限</th>
                <th><input class="usestock" name="usestock" /></th>
            </tr>
        </form>
    </table>
@endsection
