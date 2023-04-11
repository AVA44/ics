<DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>お菓子の在庫/@yield('title')</title>
<link rel="stylesheet" href="{{ asset('/css/template.css') }}" >
<link rel="stylesheet" href="{{ asset('/css/all.css') }}" >
@yield('pageCss')
@yield('pageJs')
</head>
    <body>
        @component('components.header')
        @endcomponent

        <div id="contents">
            <!-- コンテンツ -->
            <div id="main">
                @yield('content')
            </div>
        </div>

        @component('components.footer')
        @endcomponent
    </body>
</html>
