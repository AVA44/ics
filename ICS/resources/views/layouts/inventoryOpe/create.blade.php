@extends('template.app')

@section('title', '新景品追加')

@section('pageJs')
    <script src="{{ mix('js/create.js') }}"></script>
@endsection

@section('content')

    <!-- 景品追加フォーム -->
    <h2 id="create_top">新景品追加</h3>

    <div id="create_container">
        <form id="create_form" method="post" enctype="multipart/form-data" action="{{ route('inventory.store') }}">
            @csrf
            <div class="create_form_content required empty_alert">
                <label class="create_label" for="name">景品名</label>
                <span>：</span>
                <input class="name create_input" name="name" type="text"/>
            </div>
            <div class="create_form_content">
                <label class="create_label" for="category_name">カテゴリ</label>
                <span>：</span>
                <select class="categroy_name create_input" name="category_name">
                    @foreach ($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="create_form_content required empty_alert">
                <label class="create_label" for="parchase">１箱の入数</label>
                <span>：</span>
                <input class="parchase create_input" name="parchase" type="number" min="0" />
            </div>
            <div class="create_form_content required empty_alert">
                <label class="create_label" for="box_price">箱単価</label>
                <span>：</span>
                <input class="box_price create_input" name="box_price" type="number" min="0" />
            </div>
            <div class="create_form_content">
                <label class="create_label">ランク</label>
                <span>：</span>
                <input type="radio" name="lank_flag" value="yes" checked />あり
                <input type="radio" name="lank_flag" value="no" />なし
            </div>
            <div id="input_image" class="create_form_content">
                <label class="create_label" for="image_url">画像</label>
                <span>：</span>
                <input id="image_url" name="image_url" accept='image/*' type="file" />
            </div>
            <input id="create_submit" type="button" value="作成" />
        </form>
        <div id="preview_field">
            <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
        </div>
    </div>
@endsection
