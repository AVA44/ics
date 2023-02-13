<DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>お菓子の在庫/@yield('title')</title>
<!-- <link href="/css/star/layout.css" rel="stylesheet"> -->
@yield('pageCss')
@yield('pageJs')
</head>
    <body>
        @component('components.header')
        @endcomponent

        <div class="contents">
            <!-- コンテンツ -->
            <div class="main">
                @yield('content')
            </div>
        </div>

        @component('components.footer')
        @endcomponent
    </body>
</html>
