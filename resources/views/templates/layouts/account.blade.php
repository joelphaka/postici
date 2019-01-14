@extends('templates.layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1 class="margin-top-0 margin-bottom-25">Account</h1>
            <ul class="nav nav-tabs default orientable">
                <li>
                    <a href="{{ route('account.index') }}" class="btn btn-default">
                        General
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.edit') }}" class="btn btn-default">
                        Edit
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.security') }}" class="btn btn-default">
                        Security
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="margin-top-30"></div>
                @yield('tabContent')
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection