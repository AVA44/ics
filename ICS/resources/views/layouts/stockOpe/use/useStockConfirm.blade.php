@extends('template.app')

@section('title', '景品出庫')
@section('pageCss', '')

@section('content')

        <h3>選択した景品</h3>

    @if (count($name_conf) > 0)
        <!-- useStock.blade.phpで入力した入庫情報 -->
        <hr />
        @for ($i = 0; $i < count($name_conf); $i++)
            <div class="confilm_container" style="display: flex;">
                <p>{{ $name_conf[$i] }} /</p>
                <p>{{ $expired_at_conf[$i] }} /</p>
                <p>{{ $limited_at_conf[$i] }} /</p>
                <p>{{ $stock_conf[$i] }}</p>
            </div>
            <hr />
        @endfor
    @else
        <h2>景品使用:なし</h2>
    @endif
        <h1>成功</h1>
@endsection
