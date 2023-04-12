@extends('template.app')

@section('title', '景品出庫')
@section('pageCss', '')

@section('content')

    <h2>使用した景品</h2>
    <h2>景品名 / 味 / 賞味期限 / 使用期限 / 追加数</h2>

    @if (count($name_conf) > 0)

        <!-- useStock.blade.phpで入力した入庫情報 -->
        <hr />
        @for ($i = 0; $i < count($name_conf); $i++)
            <div id="confirm_container">
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
    
@endsection
