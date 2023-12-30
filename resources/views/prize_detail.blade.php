@section('contents')
<div id="prizeDetail">
    <!-- 景品の情報 -->
    <div>
        <h2>景品名：{{ $prizes->name }}</h3>
        <p>カテゴリ：{{ $prizes->category }}</p>
        <p>箱単価：{{ $prizes->price_per_box }}円</p>
        <p>入り数；{{ $prizes->snp_per_box }}個</p>
        <p>単価：{{ round($prizes->price_per_box / $prizes->snp_per_box) }}円</p>
    </div>

    <div id="prizeDetailTable">
        <prize-detail-table prize_id="{{ $id }}"></prize-detail-table>
    </div>
</div>
@endsection('contents')

@include('template', ['title' => '景品詳細'])
