<html>
    @php
        $title = "テンプレート";
        $css = "";
        $javascript = '';
    @endphp
    <head>
        <meta charset="utf-utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>{{ $title }}</title>
        <link rel="stylesheet" href="{{ $css }}" />
        <script type="module" src="{{ $javascript }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div id="templateContainer">
            @include('header')
            @yield('contents')
            @include('footer')
        </div>
    </body>
</html>
