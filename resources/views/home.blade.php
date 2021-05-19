@extends('layouts.app')

@section('content')
<div class="container" style="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a class="ml-3" href="{{ route('register') }}">Get <strong>$10 instantly</strong> for signing up</a>
                </div>

                <img class="card-img-top" style="" src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/0b82f586447457.5d9a12788637f.jpg" />
                
                <div class="row">
                    <span class="col media_font_size" style="text-align: center; color: grey;">Free sheeping</span>
                    <span class="col media_font_size" style="text-align: center; color: grey;">&#8226; Next day delivery</span>
                    <span class="col media_font_size" style="text-align: center; color: grey;">&#8226; Easy return</span>
                </div>

                <div class="card-body" style="margin-bottom: 10vh;">

                    <div class="splide" id="categories_splide_main">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($categories as $cat)
                                    <li class="splide__slide">
                                        <a href="{{ route('categories_paged_items', $cat->id) }}">
                                            <img class="d-block w-20" style="margin: auto; border-radius: 50px;" src="{{ asset( $cat->image_uri ) }}" alt="First slide">
                                            <h5 class="mt-2" style="text-align: center; font-size: 100%; color: grey;">{{ $cat->name }}</h5>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="splide__slide">
                                    <a href="{{ route('categories_paged_items', 0) }}">
                                        <img class="d-block w-20" style="margin: auto; border-radius: 50px;" src="{{ asset('images/icons/misc_ic.png') }}" alt="First slide">
                                        <h5 class="mt-2" style="text-align: center; font-size: 100%; color: grey;">Misc</h5>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr />

                    <div class="row" style="text-align: center; margin-top: 10px;">
                        <div class="col" style="border-right: 2px solid grey;">
                            <a href="javascript:void(0)" class="regular_link selected_link_special" id="index_items_new">New</a>
                        </div>
                        <div class="col" style="border-right: 2px solid grey;">
                            <a href="javascript:void(0)" class="regular_link" id="index_items_best_sellers" class="col">Tops</a>
                        </div>
                        <div class="col">
                            <a href="javascript:void(0)" class="regular_link" id="index_items_hits" class="col">For You</a>
                        </div>
                    </div>

                    <br />

                    <div id="carouselForNewItems" class="hidden_element visible_element carousel responsiveSplash slide p-2" data-ride="carousel" style="border-radius: 10px;">
                        <div class="carousel-inner">
                            @foreach ($new_products as $idx => $new_product)
                                @if ($idx == 0)
                                    <div class="carousel-item active">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div id="carouselForTopItems" class="hidden_element carousel responsiveSplash slide p-2" data-ride="carousel" style="border-radius: 10px;">
                        
                        <div class="carousel-inner">
                            @foreach ($top_products as $idx => $new_product)
                                @if ($idx == 0)
                                    <div class="carousel-item active">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div id="carouselForHitItems" class="hidden_element carousel responsiveSplash slide p-2" data-ride="carousel" style="border-radius: 10px;">
                        
                        <div class="carousel-inner">
                            @foreach ($recommended as $idx => $new_product)
                                @if ($idx == 0)
                                    <div class="carousel-item active">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        @if (isset($new_product->image_uri))
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{ $new_product->image_uri }}" alt="First slide">
                                        @else
                                            <img class="d-block responsive_selected_tab_product_image" style="margin: auto;" src="{{asset('images/no_image.jpg')}}" alt="First slide">
                                        @endif
                                        <div class="carousel-caption d-md-block tab_items_capture">
                                            <a href="javascript:void(0)" style="color: white;">
                                                <h5>{{ $new_product->name }}</h5>
                                                <p>{{ $new_product->description }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
