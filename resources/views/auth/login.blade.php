@extends('layouts.app-login', ['class' => 'bg-white'])

@section('content')
<style>
    @media only screen and (max-width: 575px) {
        .d-sm-none {
            display: none !important;
        }
    }

    .vh-100 {
        height: 100vh;
    }
</style>
<section class="vh-100">
    <div class="row h-100">
        <div class="col-sm-6 text-black">
            <div class="d-flex align-items-center px-6 ms-xl-4 h-100">

                <form role="form" method="POST" action="{{ route('login') }}" style="width: 30rem;">
                    @csrf

                    <h1 class="fw-normal text-black" style="letter-spacing: 1px;">Log in</h1>
                    <p class="small mb-3 pb-lg-2">See your growth get CRM support</p>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">

                        <label class="form-label" style="font-size: small;">Email address</label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control{{ $errors->has('email') || $errors->has('sso') ? ' is-invalid' : '' }}" placeholder="{{ __('Email or Username') }}" type="text" name="email" value="{{ old('sso') ?: old('email') }}" value="admin@crm.com" required autofocus>
                        </div>
                        @if ($errors->has('email') || $errors->has('sso'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('sso') ?: $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label class="form-label" style="font-size: small;">Password</label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" value="secret" required>
                        </div>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="custom-control custom-control-alternative custom-checkbox">
                        <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheckLogin">
                            <span class="text-muted">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="pt-3 mb-3">
                        <button type="submit" class="btn btn-active btn-lg btn-block">{{ __('Login') }}</button>
                    </div>
                    <!-- <p class="small mb-2 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                    <p class="small">Don't have an account? <a href="{{ route('register') }}" class="link-info">Sign Up here</a></p> -->
                    <div class="divider d-flex align-items-center my-2">
                        <p class="text-center fw-bold mx-3 mb-0">or</p>
                    </div>
                    <div class="pt-3 mb-3">
                        <a  style="border-color: lightgrey" class="btn btn-white btn-lg btn-block" href="{{route('ssoLogin')}}"><span class="btn-inner--icon" style="margin-right: 15px;"><img src="{{ asset('argon') }}/img/icons/common/google.svg" style="width: 20px"></span></a>
                    </div>
                </form>

            </div>

        </div>

        <div class="col-sm-6 d-md-block d-sm-none">
            <div class="d-flex justify-content-end">
                <div>
                    <img src="{{ asset('argon') }}/img/theme/bg-login.png" />
                    <div class="position-absolute w-100 h-100" style="top: 0; left: 0;">
                        <div style="position: absolute;top: 110px;right: 100px;">
                            <p class="text-white m-0" style="font-size: 28px;">Welcome to our</p>
                            <h2 class="text-white m-0" style="font-size: 40px;">CRM Pertamina University</h2>
                            <p class="text-white m-0" style="font-size: 18px;">Become a World Class University in the
                                field of Energy</p>
                        </div>
                        <img src="{{ asset('argon') }}/img/theme/login-ds.png" style="position: absolute;right: 0px;bottom: 0px;" />

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection