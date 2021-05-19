@extends('layouts.app')

@section('content')
<div class="container" style="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 10vh;">
                <div class="splide" id="categories_splide_categories">
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
                <h3 style="text-align: center;">{{ $current_cat['name'] }}</h3>

                @if (count($products) > 0)
                    @foreach ($products as $p)
                        <div class="row" style="margin: 5px; margin-bottom: 10px;">
                            <div class="col-4">
                                @if (isset($p->image_uri))
                                    <img style="width: 100px; height: 100px;" src="{{ $p->image_uri }}" />
                                @else
                                    <img style="width: 100px; height: 100px;" src="{{ asset('images/no_image.jpg') }}" />
                                @endif
                            </div>
                            <div class="col-5">
                                <h5>{{ $p->name }}</h5>
                                <strong style="color: red;">${{ $p->price }}</strong><br />
                                <span style="font-size: 90%;">Weekly sold 90 lbs</span>
                            </div>
                            <div class="col-2">
                                <a href="javascript:void(0)">
                                    <img id="decrement_quantity" data-id="{{ $p->id }}" class="" src="{{ asset('images/icons/minus.png') }}" />
                                </a>
                                <input id="quantity_{{ $p->id }}" class="categoriesProductCountWidth" style="border: none; background-color: white;" type="number" value="0" disabled />
                                <a href="javascript:void(0)">
                                    <img class="" id="increment_quantity" data-id="{{ $p->id }}" src="{{ asset('images/icons/add.png') }}" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 style="text-align: center; font-style: italic;">No products found!</h5>
                @endif

                @if ($pages_count > 1)
                    <hr />
                    <div style="margin: auto;">
                        <ul style="list-style-type: none;">
                            @foreach(range(1, $pages_count) as $page)
                                <li class="mr-2" style="float: left;">
                                    <a href="{{ route('categories_paged_items', $current_cat->id, $page) }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
