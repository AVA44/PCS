<html>
    <head>
        <meta charset="utf-utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>景品一覧</title>
        <link rel="stylesheet" href="" />
        <script type="module" src=""></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>

        <div id="prizeDetail">
            <!-- 景品の情報 -->
            <div>
                <h2>景品名：{{ $prizes->name }}</h3>
                <p>カテゴリ：{{ $prizes->category }}</p>
                <p>箱単価：{{ $prizes->price_per_box }}円</p>
                <p>入り数；{{ $prizes->snp_per_box }}個</p>
                <p>単価：{{ round($prizes->price_per_box / $prizes->snp_per_box) }}円</p>
            </div>


<!-- ここから下をvueで作成　ajaxを使ってstocksを取得　stocksDeleteも同じページで作成　 -->
            <div id="prizeDetailTable">
                <prize-detail-table prize_id="{{ $id }}"></prize-detail-table>
            </div>

        </div>
    </body>
</html>
