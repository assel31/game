@extends('index')

@section('content')
<div class="container">
    <h1>Day: {{ $day }}</h1>
    <h1>All: {{ $allSheeps }}</h1>
    <h1>Deleted: {{ $deleted }}</h1>
    <h1>Alive: {{ $alive }}</h1>
</div>
@endsection
