@extends('layouts.app')

@section('content')
<div class="container" style="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 10vh;">
                <div class="card-header mb-2">
                    <div class="row">
                        <div class="col" style="text-align: center; color: grey;">
                            Total price: $<strong id="total_price">{{ $total_cost }}</strong>
                            <br />
                            Items: <strong id="total_count">0</strong>
                        </div>
                        <div class="col" style="text-align: center;">
                            <button class="btn btn-secondary" id="order_checkout">Checkout</button>
                        </div>
                    </div>
                </div>

                <h3 style="text-align: center;">Ordered Products</h3>

                @if (isset($products))
                    @foreach ($products as $x)
                        <div class="row" style="margin: 5px; margin-bottom: 10px;">
                            <div class="col-4">
                                @if (isset($x->image_uri))
                                    <img style="width: 100px; height: 100px;" src="{{ $x->image_uri }}" />
                                @else
                                    <img style="width: 100px; height: 100px;" src="{{ asset('images/no_image.jpg') }}" />
                                @endif
                            </div>
                            <div class="col-5">
                                <h5>{{ $x->name }}</h5>
                                <strong style="color: red;">${{ $x->price }}</strong><br />
                                <span style="font-size: 90%;">Weekly sold 90 lbs</span>
                            </div>
                            <div class="col-2">
                                <a href="javascript:void(0)">
                                    <img id="decrement_quantity" data-id="{{ $x->id }}" class="" src="{{ asset('images/icons/minus.png') }}" />
                                </a>
                                <input id="quantity_{{ $x->id }}" class="categoriesProductCountWidth" style="border: none; background-color: white;" type="number" value="0" disabled />
                                <a href="javascript:void(0)">
                                    <img class="" id="increment_quantity" data-id="{{ $x->id }}" src="{{ asset('images/icons/add.png') }}" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 style="text-align: center; font-style: italic;">No products found!</h5>
                @endif
            </div>
        </div>
    </div>
    
    <form method="POST" style="visibility: none;">
        @csrf
    </form>
</div>
@endsection
