@extends('templates.layouts.account')

@section('styles')
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.structure.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/assets/jquery-ui/jquery-ui.theme.css') }}" type="text/css">
@endsection

@section('pageTitle') Edit|Account @endsection()

@section('tabContent')
    <div class="row">
        <div class="col-md-8 col-sm-9">
            @include('templates.partials.alerts')
            <form action="{{ route('account.update') }}" method="post" id="form103">
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="" class="text-danger">* Required</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6 {{ $errors->has('firstname') ? 'has-error':'' }}">
                        <label for="firstname" class="control-label">
                            <span>First name</span>
                            <span class="text-danger">&nbsp;*</span>
                        </label>
                        <?php #print_r(Input::all());?>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name"
                               value="{{ old('firstname')?: Auth::user()->firstname }}">
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
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name"
                               value="{{ old('lastname')?: Auth::user()->lastname }}">
                        @if ($errors->has('lastname'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('lastname') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('gender') ? 'has-error':'' }}">
                        <label for="gender" class="control-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <?php $userGender = (int)old('gender') ?: Auth::user()->gender?>
                            <option value="-1">Select gender</option>
                            <option value="1" {{ $userGender === 1 ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ $userGender === 2 ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('birthdate') ? 'has-error':'' }}">
                        <label for="birthdate" class="control-label">Birthdate</label>
                        <span>&nbsp;(format: yyyy-mm-dd, example: 1998-12-31)</span>
                        <input class="form-control" type="text" name="birthdate" id="birthdate" ui-control="datepicker" placeholder="Birthdate"
                               value="{{ old('birthdate')?: Auth::user()->birthdate ? Auth::user()->birthdate->format('Y-m-d') : null }}">
                        @if ($errors->has('birthdate'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('birthdate') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 {{ $errors->has('country_id') ? 'has-error':'' }}">
                        <label for="country_id" class="control-label">
                            Country
                        </label>
                        <select name="country_id" id="country_id" class="form-control">
                            <option value="-1">Select country</option>
                        </select>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="margin-top-30"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Save
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
            $('#form103').validate(validator({
                rules: {
                    firstname: {required: true, notEmpty: true},
                    lastname: {required: true, notEmpty: true},
                }
            }));

            $('[type="date"], [ui-control="datepicker"]').datepicker({dateFormat: 'yy-mm-dd'});

            $.get("{{ route('api.countries') }}")
                .done(function (resp) {
                    var countrySelect = $('#country_id');
                    var userCountry = '{{ Auth::user()->country_id }}';

                    resp.data.forEach(function (country) {
                        var optEl = $('<option>');
                        optEl.val(country.id);
                        optEl.text(country.name);

                        if (userCountry == country.id) {
                            optEl.attr('selected', true);
                        }

                        countrySelect.append(optEl);
                    });
                })
                .fail(function () {
                    console.log('Failed to load countries');
                })
        });
    </script>
@endsection