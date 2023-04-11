@extends('template.app')

@section('title', '景品入庫')
@section('pageCss', '')

@section('content')

    <h2>追加した景品</h2>
    <h2>景品名 / 味 / 賞味期限 / 使用期限 / 追加数</h2>

    <!-- 追加した景品の情報確認 -->
    <hr />
    @for ($i = 0; $i < count($name_conf); $i++)
        <div id="confirm_container">
            <p>{{ $name_conf[$i] }} /</p>
            <p>{{ $taste_name_conf[$i] }} /</p>
            <p>{{ $expired_at_conf[$i] }} /</p>
            <p>{{ $limited_at_conf[$i] }} /</p>
            <p>{{ $stock_conf[$i] }}</p>
        </div>
        <hr />
    @endfor
@endsection
