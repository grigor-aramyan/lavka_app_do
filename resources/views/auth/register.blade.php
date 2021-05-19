@extends('layouts.app')

@section('content')
<div style="border: 1px solid white; background-color: white; position: absolute; top: 0; width: 100vw; height: 5vh;">
    <div class="row">
        <div class="col-2">
            <a href="#" class="ml-2">
                <img  src="{{ asset('images/icons/left_arrow.png') }}" />
            </a>
        </div>
        <div class="col-8">
            <h3 style="text-align: center;"><strong>Sign Up</strong></h3>
        </div>
        <div class="col-2 h5">
            <a href="{{ route('without_register') }}">Skip</a>
        </div>
    </div>
</div>
<div class="container" style="margin-top: 6vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center;">
                    <a href="javascript:void(0);" id="email_reg_link" class="mr-2 active_link">
                        Email
                    </a>
                    <a href="javascript:void(0);" id="phone_reg_link" class="ml-2 regular_link">
                        Phone
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" id="email_reg_form" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="label_style col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input style="border-radius: 10px;" id="email" type="email" class="rounded_input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="label_style col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="rounded_input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="mt-2" style="text-align: center;">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">Log In</a>
                        </div>
                    </form>

                    <form method="POST" id="phone_reg_form" class="d-none">
                        @csrf

                        <div class="form-group row">
                            <label for="phone" class="label_style col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" placeholder="+1234567" type="tel" class="rounded_input form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sms_code" class="label_style col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                            <div class="col-md-6">
                                <input id="sms_code" class="rounded_input form-control @error('sms_code') is-invalid @enderror" name="sms_code" required autocomplete="sms_code">

                                @error('sms_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="login_with_phone" type="submit" class="btn btn-primary">
                                    {{ __('Request code') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
