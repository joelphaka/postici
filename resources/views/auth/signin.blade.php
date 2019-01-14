@extends('templates.layouts.plain')

@section('pageTitle') Login @endsection

@section('content')
    <?php $continue = request()->query('continue');?>
    <form action="{{ $continue ? route('auth.signin', ['continue'=> $continue]) :  route('auth.signin') }}"
          method="post" class="row" id="form102">
        <div class="col-xs-12 form-content">
            <section class="margin-top-25 margin-bottom-20">

                <h1 class="main-header text-center margin-top-15">Sign in</h1>
                <a href="{{ url('/assets/images/user-icon.png') }}" class="img-circle user-icon center-block margin-top-20">
                    <img src="{{ url('/assets/images/user-icon.png') }}" class="img-circle user-icon center-block" alt="logo">
                </a>
                <div class="text-center v-space-20">Sign in with your credentials</div>
                @if (Session::has('info'))
                    @if (Session::has('info_type'))
                        <div class="text-center text-{{ Session::get('info_type') }} v-space-5">
                            {{ Session::get('info') }}
                        </div>
                    @else
                        <div class="text-center text-info v-space-5">
                            {{ Session::get('info') }}
                        </div>
                    @endif
                @endif
            </section>
            <section>
                <div class="form-group">
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block error" style="margin-bottom:2px">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <div class="margin-top-5"></div>
                        <span class="help-block error" style="margin-bottom:2px">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="remember">
                        <input type="checkbox" class="checkbox-inline" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span style="font-weight:normal">Remember me</span>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <span>Sign in</span>
                    </button>
                </div>
                <div class="text-center margin-top-25">
                    <span>Don't have an account?&nbsp;</span>
                    <a href="{{ route('auth.signup') }}">Create one</a>
                </div>
            </section>
        </div>
    </form>
@endsection