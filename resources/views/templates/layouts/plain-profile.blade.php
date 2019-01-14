@extends('templates.layouts.profile')

@section('styles')
    <style>
        .profile-header, .profile-header + hr {
            display: none;
        }
        @media all and (max-width: 767px){
            #contentWrapper {
                display: flex;
                flex-flow: column;
            }
            #contentWrapper > #followContent,
            #contentWrapper > #userRequests {
                flex: 1;
            }

            #contentWrapper > #followContent {
                order: 2;
            }

            #contentWrapper > #userRequests {
                order: 1;
            }
        }

    </style>
    @yield('moreStyles')
@endsection

@section('content')
    <div class="row" id="contentWrapper">
        <div id="followContent" class="col-md-8">
            @yield('mainContent')
            <div class="margin-bottom-50"></div>
        </div>
        <div id="userRequests" class="col-md-4">
            @yield('sideContent')
            <div class="margin-bottom-30"></div>
        </div>
    </div>
@endsection

