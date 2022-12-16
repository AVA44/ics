v@extends('template.app')

@section('title', '景品入庫')
@section('pageCss', '')

@section('content')

    <h3>選択した景品</h3>

    <!-- addStock.blade.phpで選択した景品一覧と追加する情報入力フォーム -->
    <table>
        <tr>
            <th>名前</th>
            <th>カテゴリ</th>
            <th>賞味期限</th>
            <th>追加する個数</th>
        </tr>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品１</th>
                <th>カテゴリ１</th>
                <th><input class="expired_at" name="expired_at" /></th>
                <th><input class="stock" name="stock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品2</th>
                <th>カテゴリ2</th>
                <th><input class="expired_at" name="expired_at" /></th>
                <th><input class="stock" name="stock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品3</th>
                <th>カテゴリ3</th>
                <th><input class="expired_at" name="expired_at" /></th>
                <th><input class="stock" name="stock" /></th>
            </tr>
        </form>
        <form>
            <input type="hidden" value="景品ID" />
            <tr>
                <th>景品4</th>
                <th>カテゴリ4</th>
                <th><input class="expired_at" name="expired_at" /></th>
                <th><input class="stock" name="stock" /></th>
            </tr>
        </form>
    </table>
@endsection
