@extends('templates.layouts.plain-profile')

@section('pageTitle') Following @endsection

@section('mainContent')
    <h3 class="margin-top-0">People you're following</h3>
    <div class="margin-bottom-25"></div>
    @if ($people->count())
        <ul class="list-group space-items">
            @foreach ($people as $person)
            @include('templates.partials.personblock')
            @endforeach
        </ul>
    @else
        <p>You are not following anyone.</p>
    @endif()
@endsection
@section('sideContent')
    <h3 class="margin-top-0">Your requests sent</h3>
    <div class="margin-bottom-25"></div>
    @if (Auth::user()->pendingFollowing()->count())
        <ul class="list-group space-items">
            @foreach (Auth::user()->pendingFollowing()->limit(5)->get() as $person)
                @include('templates.partials.personblock')
            @endforeach
        </ul>
    @else
        <p>YOu have noy sent any request.</p>
    @endif
@endsection

@section('paginator')
    {!! $people->render() !!}
@endsection