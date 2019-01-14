@extends('templates.layouts.plain-profile')

@section('pageTitle') Following @endsection

@section('mainContent')
    <h3 class="margin-top-0">Your followers</h3>
    <div class="margin-bottom-25"></div>
    @if ($people->count())
        <ul class="list-group space-items">
            @foreach ($people as $person)
                @include('templates.partials.personblock')
            @endforeach
        </ul>
    @else
        <p>You have no followers.</p>
    @endif()
@endsection
@section('sideContent')
    <h3 class="margin-top-0">Your requests received</h3>
    <div class="margin-bottom-25"></div>
    @if (Auth::user()->pendingFollowers()->count())
        <ul class="list-group space-items">
            @foreach (Auth::user()->pendingFollowers()->limit(5)->get() as $person)
                @include('templates.partials.personblock')
            @endforeach
        </ul>
        @if (!Auth::user()->pendingFollowers()->count() > 5)
            <button class="btn btn-primary btn-block">More</button>
        @endif
    @else
        <p>You have no requests waiting to be accepted.</p>
    @endif
@endsection

@section('paginator')
    {!! $people->render() !!}
@endsection