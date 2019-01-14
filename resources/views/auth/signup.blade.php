@extends('templates.layouts.default')

@section('styles')
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.structure.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.theme.css') }}" type="text/css">
@endsection

@section('content')
    <div class="row margin-top-10">
        <div class="col-md-8 col-sm-10 col-md-offset-2 col-sm-offset-1">
            <h1>Create an account</h1>
            <h5 class="text-muted">
                Fill in the form to complete your registration
            </h5>
        </div>
    </div>
    <div class="row">
        <hr class="col-md-12 col-sm-12 margin-top-5 margin-bottom-0">
    </div>
    <div class="row margin-top-30 margin-bottom-10">

    </div>
    <div class="row">
        <div class="col-md-8 col-sm-10 col-md-offset-2 col-sm-offset-1 margin-bottom-35">

            <form action="{{ route('auth.signup') }}" method="post" id="form101" novalidate="novalidate">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="text-danger">* Required</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 {{ $errors->has('firstname') ? 'has-error':'' }}">
                        <label for="firstname" class="control-label">
                            <span>First name</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First name" value="{{ old('firstname') }}">
                        @if ($errors->has('firstname'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('firstname') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 col-sm-6 {{ $errors->has('lastname') ? 'has-error':'' }}">
                        <label for="lastname" class="control-label">
                            <span>Last name</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last name" value="{{ old('lastname') }}">
                        @if ($errors->has('lastname'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('lastname') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 {{ $errors->has('gender') ? 'has-error':'' }}">
                        <label for="gender" class="control-label">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="-1">Select gender</option>
                            <option value="1" {{ (int)old('gender') === 1 ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ (int)old('gender') === 2 ? 'selected' : '' }}>Female</option>
                        </select>
                        @if ($errors->has('gender'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('gender') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 col-sm-6" {{ $errors->has('birthdate') ? 'has-error':'' }}>
                        <label for="birthdate" class="control-label">Birthdate</label>
                        <span>&nbsp;(format: yyyy-mm-dd, example: 1998-12-31)</span>
                        <input class="form-control" type="text" name="birthdate" id="birthdate" ui-control="datepicker" placeholder="Birthdate" value="{{ old('birthdate') }}">
                        @if ($errors->has('birthdate'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('birthdate') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('email') ? 'has-error':'' }}">
                        <label for="email" class="control-label">
                            <span>Email</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('username') ? 'has-error':'' }}">
                        <label for="username" class="control-label">
                            <span>Username</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                        @if ($errors->has('username'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('username') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('password') ? 'has-error':'' }}">
                        <label for="password" class="control-label">
                            <span>Password</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="{{ old('password') }}">
                        @if ($errors->has('password'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('password_confirmation') ? 'has-error':'' }}">
                        <label for="confirm_password" class="control-label">
                            <span>Confirm password</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
                        @if ($errors->has('password_confirmation'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 form-group margin-top-10 margin-bottom-15">
                        <label for="accept_tcs">
                            <input class="checkbox-inline" type="checkbox" name="accept_tcs" id="accept_tcs">
                            <span>Accept terms and conditions xyz</span>
                            @if ($errors->has('accept_tcs'))
                                <div class="error help-block">{{ $errors->first('accept_tcs') }}</div>
                            @endif
                        </label>
                        <div class="margin-bottom-5"></div>
                        <div>By accepting the terms and condition you agree with abcde</div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="form-group col-md-12 col-sm-12">
                        <button class="btn btn-primary btn-block" type="submit">
                            <span>Register</span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('/assets/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ url('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/assets/js/validator.js') }}"></script>
    <script>
        $(function () {
            $('#birthdate').datepicker({dateFormat: 'yy-mm-dd'});
            $('#form101').validate(validator({
                rules: {
                    firstname: {
                        required: true,
                        notEmpty: true,
                        maxlength: 32,
                    },
                    lastname: {
                        required: true,
                        notEmpty: true,
                        maxlength: 32,
                    },
                    birthdate: {
                        dateISO: true
                    },
                    email: {
                        required: true,
                        email: true,
                        notEmpty: true,
                        maxlength: 100
                    },
                    username: {
                        required: true,
                        notEmpty: true,
                        minlength: 6,
                        maxlength: 32,
                        alphaNumeric: true
                    },
                    password: {
                        required: true,
                        notEmpty: true,
                        minlength: 6,
                        maxlength: 255,
                    },
                    confirm_password: {
                        equalTo: '#password'
                    },
                    accept_tcs: {
                        required: true
                    }
                },
                messages: {
                    accept_tcs: {
                        required: 'You must accept the terms and conditions.'
                    }
                }
            }));
        });
    </script>
@endsection


