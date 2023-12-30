@section('contents')
<div id="prizeCreate">
    <prize-create input-categories="{{ json_encode($categories) }}"></prize-create>
</div>
@endsection('contents')

@include('template', ['title' => '景品作成'])
