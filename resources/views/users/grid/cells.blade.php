@section('name')
    <img src="https://robohash.org/{{ $item->name }}.png?size=16x16" />
    {{ $item->name }}
@stop