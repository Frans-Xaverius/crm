@extends('layouts.app-login', ['class' => 'bg-white'])

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6 text-black">
              <div class="d-flex align-items-center h-custom-2 px-6 ms-xl-4 mt-7 pt-3 pt-xl-1 mt-xl-n5">
      
                <form role="form" method="POST" action="{{ route('register') }}" style="width: 30rem;">
                    @csrf
      
                  <h1 class="fw-normal text-black" style="letter-spacing: 1px;">Sign Up</h1>
                  <p class="small mb-3 pb-lg-2">See your growth get CRM support</p>
                  <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                    
                    <label class="form-label" style="font-size: small;">Full Name</label>
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Full Name') }}" type="text" name="name" value="{{ old('name') }}" value="admin@crm.com" required autofocus>
                    </div>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                    
                    <label class="form-label" style="font-size: small;">Email Address</label>
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
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
                  <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label class="form-label" style="font-size: small;">Re-type Password</label>
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="rpassword" placeholder="{{ __('Re-type Password') }}" type="password" value="secret" required>
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="pt-1 mb-3">
                    <button type="submit" class="btn btn-active btn-lg btn-block">{{ __('Sign Up') }}</button>
                  </div>
                  <p class="small">Already have an account? <a href="{{ route('login') }}" class="link-info">Sign In here</a></p>
                  <div class="divider d-flex align-items-center my-2">
                    <p class="text-center fw-bold mx-3 mb-0">or</p>
                  </div>
                </form>
      
              </div>
      
            </div>
            <div class="col-sm-6 d-sm-block">
                <img src="{{ asset('argon') }}/img/theme/bg-login.png" style="margin-left: -150px; margin-top: -30px; position: absolute" />
                <img src="{{ asset('argon') }}/img/icons/common/call-center.svg" style="left: 450px; top: 100px; position: absolute; width: 75px;" />
                <img src="{{ asset('argon') }}/img/icons/common/fb.svg" style="right: -25px; top: 270px; position: absolute; width: 55px;" />
                <img src="{{ asset('argon') }}/img/icons/common/ig.svg" style="right: 50px; top: 490px; position: absolute; width: 75px;" />
                <img src="{{ asset('argon') }}/img/icons/common/wa.svg" style="right: 300px; top: 550px; position: absolute; width: 75px;" />
                <img src="{{ asset('argon') }}/img/theme/register-ds.png" style="left: 100px; top: 200px; position: absolute; width: 500px;" />
            </div>
          </div>
        </div>
    </section>
@endsection
