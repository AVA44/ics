<!-- カテゴリー一覧取得 -->
@php
    $categories = array();
    $tmpkey = array();
    foreach ($inventories as $inventory){
        if (!isset($tmpkey[$inventory->category_name])){
            $categories[] = $inventory->category_name;
            $tmpkey[$inventory->category_name] = "true";
        }
    }
@endphp

<label for="name_search">名前検索：</label>
<input class="name_search" name="name_search" type="text" />

<label for="cate_search">カテゴリ検索：</label>
<select class="cate_search" name="cate_search">
    <option value="">カテゴリ選択</option>
    @foreach ($categories as $category)
        <option value="{{ $category }}">{{ $category }}</option>
    @endforeach
</select>

<button class="orderBtn">検索</button>
