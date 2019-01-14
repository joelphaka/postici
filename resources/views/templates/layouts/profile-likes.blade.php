@extends('templates.layouts.profile')

@section('pageHeader') Likes @endsection

@section('content')
    <ul class="nav nav-tabs default orientable">
        <li class="active">
            <a href="{{ route('user.likes.posts', ['username'=>$user->username]) }}" class="btn btn-default">
                Posts
            </a>
        </li>
        <li>
            <a href="{{ route('user.likes.comments', ['username'=>$user->username]) }}" class="btn btn-default">
               Comments
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="margin-top-30"></div>
        @yield('tabContent')
    </div>
@endsection
