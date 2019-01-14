@extends('templates.layouts.search')

@section('pageTitle') Search|People: {{ request()->query('q') }} @endsection()

@section('tabContent')
    <div class="tab-pane active">
        <ul class="list-group space-items">
            @foreach ($people as $person)
                @include('templates.partials.userblock')
            @endforeach
        </ul>
    </div>
@endsection()

@section('paginator')
    {!! $people->render() !!}
@endsection()