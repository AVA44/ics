<DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お菓子の在庫/@yield('title')</title>
<!-- <link href="/css/star/layout.css" rel="stylesheet"> -->
@yield('pageCss')
<!-- <script src="{{ mix('js/ajax.js') }}"></script> -->
</head>
<body>

@component('components.header')

<div class="contents">
    <!-- コンテンツ -->
    <div class="main">
        @yield('content')
    </div>
</div>

@component('components.footer')
</body>
</html>
