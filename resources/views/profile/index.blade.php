@extends('templates.layouts.profile')

@section('pageTitle') About @endsection

@section('pageHeader') About @endsection

@section('extraHeader')
    @if ($user->isAuthUser())
        <div class="button-group pull-right">
            <a href="{{ route('account.edit') }}" class="btn btn-primary">
                <span class="glyphicon glyphicon-edit"></span>
                <span>Edit</span>
            </a>
        </div>
    @endif
@endsection

@section('content')
    <h3 class="margin-top-20">Basic Info</h3>
    <section class="tabular margin-top-15">
        <div class="row">
            <div class="col-sm-6">Username</div>
            <div class="col-sm-6">{{ $user->username }}</div>
        </div>
        <div class="row">
            <div class="col-sm-6">First Name</div>
            <div class="col-sm-6">{{ $user->firstname }}</div>
        </div>
        <div class="row">
            <div class="col-sm-6">Last Name</div>
            <div class="col-sm-6">{{ $user->lastname }}</div>
        </div>
        @if ($user->gender != null)
            <div class="row">
                <div class="col-sm-6">Gender</div>
                <div class="col-sm-6">
                    @if ($user->gender == 1)
                        Male
                    @elseif ($user->gender == 2)
                        Female
                    @endif
                </div>
            </div>
        @endif

        @if ($user->birthdate != null)
            <div class="row">
                <div class="col-sm-6">Date of birth</div>
                <div class="col-sm-6">{{ (new Carbon($user->birthdate))->format('d F Y') }}</div>
            </div>
        @endif

        @if ($user->country != null)
            <div class="row">
                <div class="col-sm-6">Country</div>
                <div class="col-sm-6">{{ $user->country->name }}</div>
            </div>
        @endif
        <h3 class="margin-top-35">Contact Info</h3>
        <section class="tabular margin-top-15">
            <div class="row">
                <div class="col-sm-6">Email</div>
                <div class="col-sm-6">{{ $user->email }}</div>
            </div>
        </section>
        @if ($user->biography != null)
            <h3>Bio</h3>
            <p>{{ $user->biography }}</p>
        @endif
    </section>
@endsection