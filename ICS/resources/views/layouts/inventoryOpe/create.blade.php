@extends('template.app')

@section('title', '新景品追加')

@section('pageJs')
    <script src="{{ mix('js/create.js') }}"></script>
@endsection

@section('content')

    <h2 id="create_top">新景品追加</h3>

    <!-- 景品追加フォーム -->
    <div id="create_container">
        <form id="create_form" method="post" enctype="multipart/form-data" action="{{ route('inventory.store') }}">
            @csrf
            <div class="create_form_content empty_alert">
                <label class="create_label" for="name">景品名</label>
                <span>：</span>
                <input class="create_input required" name="name" type="text" placeholder="20文字以内" />
            </div>
            <div class="create_form_content">
                <label class="create_label" for="category_name">カテゴリ</label>
                <span>：</span>
                <div>
                    <select id="category_name_input" class="create_input" name="category_name">
                        <option value="new_category">新しいカテゴリ</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    <div id="category_input_box" class="create_form_content empty_alert">
                        <input class="create_input required" type="text" name="new_category_name" placeholder="20字以内" />
                    </div>
                </div>
            </div>
            <div class="create_form_content empty_alert">
                <label class="create_label" for="parchase">１箱の入数</label>
                <span>：</span>
                <input class="create_input required" name="parchase" type="number" min="0" />
            </div>
            <div class="create_form_content empty_alert">
                <label class="create_label" for="box_price">箱単価</label>
                <span>：</span>
                <input class="create_input required" name="box_price" type="number" min="0" />
            </div>
            <div class="create_form_content">
                <label class="create_label">ランク</label>
                <span>：</span>
                <div class="create_input">
                    <input type="radio" name="lank_flag" value="yes" checked />あり
                    <input type="radio" name="lank_flag" value="no" />なし
                </div>
            </div>
            <div id="input_image" class="create_form_content">
                <label class="create_label" for="image_url">画像</label>
                <span>：</span>
                <input id="image_url" class="create_input" name="image_url" accept='image/*' type="file" />
            </div>
            <input id="create_submit" type="button" value="作成" />
        </form>
        <div id="preview_field">
            <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
        </div>
    </div>
@endsection
