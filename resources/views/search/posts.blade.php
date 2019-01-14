@extends('templates.layouts.search')

@section('pageTitle') Search|Posts: {{ request()->query('q') }} @endsection()

@section('tabContent')
    <div class="tab-pane active">
        <ul class="list-group space-items">
            @foreach ($posts as $post)
                @include('templates.partials.postblock')
            @endforeach
        </ul>
    </div>
@endsection()

@section('paginator')
    {!! $posts->render() !!}
@endsection()