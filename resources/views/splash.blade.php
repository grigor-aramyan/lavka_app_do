@extends('layouts.app')

@section('content')
    <div id="carouselExampleIndicators" class="carousel responsiveSplash slide p-2" data-ride="carousel" style="border-radius: 10px; background-color: grey;">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block" style="margin: auto;" src="{{asset('images/splash/slide2.png')}}" alt="First slide">
                <div class="carousel-caption d-md-block">
                    <h5>caption header</h5>
                    <p>caption paragraph</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block" style="margin: auto;" src="{{asset('images/splash/slide1.jpg')}}" alt="Second slide">
                <div class="carousel-caption d-md-block">
                    <h5>caption header</h5>
                    <p>caption paragraph</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block" style="margin: auto;" src="{{asset('images/splash/slide3.png')}}" alt="Third slide">
                <div class="carousel-caption d-md-block">
                    <h5>caption header</h5>
                    <p>caption paragraph</p>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center;" class="mt-3">
        <a class="mobileStart" href="{{ route('register') }}">Start</a>
    </div>
@endsection

