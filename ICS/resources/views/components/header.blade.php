<div id="header">
    <h3 id="header_title">お菓子の在庫</h3>
    <div id="header_menu">
        <a class="index" href="{{ route('inventory.index') }}">景品一覧</a>
        <a class="create" href="{{ route('inventory.create') }}">新景品追加</a>
        <a class="addStock" href="{{ route('stock.addForm') }}">景品入庫</a>
        <a class="useStock" href="{{ route('stock.useForm') }}">景品出庫</a>
        <a class="destroy" href="{{ route('inventory.destroyForm') }}">情報削除</a>
    </div>
</div>
