@extends('template.app')

@section('title', '新景品追加')
@section('pageCss', '')

@section('content')

    <!-- 景品追加フォーム -->
    <h2 id="create_top">新景品追加</h3>
    <a href="{{ route('inventory.index') }}">戻る</a>

    <form id="create_form" method="post" action="{{ route('inventory.store') }}">
        @csrf
        <div class="create_form_content required">
            <label for="name">景品名：</label>
            <input class="name" name="name" type="text"/>
        </div>
        <div class="create_form_content">
            <label for="category_name">カテゴリ：</label>
            <select class="categroy_name" name="category_name">
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <div class="create_form_content required">
            <label for="parchase">入り数(x/１箱)：</label>
            <input class="parchase" name="parchase" type="number"/>
        </div>
        <div class="create_form_content required">
            <label for="box_price">箱単価：</label>
            <input class="box_price" name="box_price" type="number"/>
        </div>
        <div class="create_form_content">
            <label>ランク：</label>
            <input type="radio" name="lank_flag" value="yes" checked />あり
            <input type="radio" name="lank_flag" value="no" />なし
        </div>
        <div class="create_form_content">
            <label for="image_url">画像：</label>
            <input class="image_url" name="image_url" type="file" />
        </div>
        <input type="submit" value="作成" />
        <input type="button" value="取消" />
    </form>
@endsection
