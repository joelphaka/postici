@extends('templates.layouts.default')

@section('content')
    <div class="row">
        <!--<div class="col-md-10 col-md-offset-1 toggleable">
            <div class="margin-top-20"></div>
            <form action="<?php route('search.index') ?>" class="search-control medium-height" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" id="q2" name="q" placeholder="Search" value="{{ request()->query('q') }}">
                </div>
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
            <hr class="margin-top-20 margin-bottom-5">
        </div>-->
        <div class="col-md-10 col-md-offset-1">
            <h2>Results for {{ request()->query('q') }}</h2>
            <div class="margin-bottom-30"></div>
            <ul class="nav nav-tabs default orientable">
                <li>
                    <a href="{{ route('search.people', ['q'=> request()->query('q')]) }}" class="btn btn-default">
                        People
                    </a>
                </li>
                <li>
                    <a href="{{ route('search.posts', ['q'=> request()->query('q')]) }}" class="btn btn-default">
                        Posts
                    </a>
                </li>
                <li>
                    <a href="{{ route('search.comments', ['q'=> request()->query('q')]) }}" class="btn btn-default">
                        Comments
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="margin-top-30"></div>
                @yield('tabContent')
            </div>
        </div>
    </div>
    @yield('paginator')
@endsection
