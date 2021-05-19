@extends('layouts.app')

@section('content')
<div style="border: 1px solid white; background-color: white; position: absolute; top: 0; width: 100vw; height: 5vh;">
    <div class="row">
        <div class="col-2">
            <a href="{{ route('register') }}" class="ml-2">
                <img  src="{{ asset('images/icons/left_arrow.png') }}" />
            </a>
        </div>
        <div class="col-8">
            <h3 style="text-align: center;"><strong>Location</strong></h3>
        </div>
        <div class="col-2 h5">
            
        </div>
    </div>
</div>
<div class="container" style="margin-top: 6vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center;">
                    Address or Zip code
                </div>

                <div class="card-body">
                    <form method="POST" id="address_zip_form">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input style="border-radius: 10px;" id="zip" type="text" class="rounded_input form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" required autocomplete="zip">

                                @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="text-align: center;">
                            <a href="javascript:void(0)" style="margin: auto;" title="Autodetect location">
                                <img style="" id="autolocate_icon" src="{{ asset('images/icons/maps_and_flags.png') }}" />
                            </a>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" id="continue_with_autodetected_address" class="rounded_input col-12 btn btn-primary">
                                    {{ __('Continue') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-2" style="text-align: center;">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}">Log In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
