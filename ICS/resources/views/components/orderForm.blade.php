<div id="order_form">

    <!-- 検索する名前の入力欄 -->
    <div id="name_search">
        <label for="name_search">名前検索 </label>
        <input class="name_search_input search_input" name="name_search" type="text" />
    </div>

    <!-- 検索するカテゴリの選択欄 -->
    <div id="cate_search">
        <label for="cate_search">カテゴリ検索 </label>
        <select class="cate_search_input search_input" name="cate_search">
            <option value="">カテゴリ選択</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <!-- 検索ボタン -->
    <button id="orderBtn">検索</button>
</div>
