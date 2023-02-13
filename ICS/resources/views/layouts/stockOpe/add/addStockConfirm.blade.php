@extends('template.app')

@section('title', '景品入庫')
@section('pageCss', '')

@section('content')

    <h3>選択した景品</h3>
    <!-- addStock.blade.phpで入力した入庫情報 -->
    <hr />
    @for ($i = 0; $i < count($name); $i++)

        <div class="confilm_container" style="display: flex;">
            <p>{{ $name[$i] }} /</p>
            <p>{{ $expired_at[$i] }} /</p>
            <p>{{ $limited_at_conf[$i] }} /</p>
            <p>{{ $taste_name[$i] }} /</p>
            <p>{{ $stock[$i] }}</p>
        </div>
        <hr />
    @endfor
    <h1>成功</h1>
@endsection
