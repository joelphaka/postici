@extends('templates.layouts.profile')

@section('pageTitle') Timeline @endsection

@section('pageHeader') People who like this {{ $type }} @endsection

@section('content')
    @if ($type == 'post')
        <?php $post = $likeable;?>
        @include('templates.partials.postblock-with-shadow')
    @elseif ($type == 'post')

    @endif
    <hr style="border-color:#cbcbcb">
    <div class="margin-bottom-30"></div>

    @if ($people->count())
        <ul class="list-group space-items">
            @foreach ($people as $person)
                @include ('templates.partials.userblock')
            @endforeach
        </ul>
    @endif
@endsection

@section('paginator')
    @if ($people->count())
        {!! $people->render() !!}
    @endif
@endsection