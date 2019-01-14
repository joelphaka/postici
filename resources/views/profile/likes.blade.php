@extends('templates.layouts.profile')

@section('pageTitle') Timeline @endsection

@section('pageHeader') Timeline @endsection

@section('content')
    @if ($posts->count())
        <ul class="list-group space-items">
            @foreach ($posts as $post)
                @include ('templates.partials.postblock')
            @endforeach
        </ul>
    @endif
@endsection

@section('paginator')
    @if ($posts->count())
        <div class="margin-top-40"></div>
        {!! $posts->render() !!}
    @endif
@endsection