@extends('templates.layouts.profile-likes')

@section('tabContent')
    <div class="tab-pane active">
        <ul class="list-group space-items">
            @foreach ($posts as $post)
                @include('templates.partials.postblock')
            @endforeach
        </ul>
    </div>
@endsection

@section('paginator')
    @if ($posts->count())
        <div class="margin-top-40"></div>
        {!! $posts->render() !!}
    @endif
@endsection