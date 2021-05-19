@extends('layouts.app')

@section('content')
<div class="container" style="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 10vh;">
                <div class="card-header mb-2">
                    <div class="row">
                        <div class="col-4" style="text-align: center; color: grey;">
                            <img class="mt-5 mt-md-2" style="border-radius: 10px; width: 80px; height: 80px;" src="https://i.ya-webdesign.com/images/profile-icon-png-2.png" />
                            <br />
                            <a class="mt-2" id="logout_id" href="javascript:void(0)">Log Out</a>
                        </div>
                        <div class="col-8 pl-2" style="padding-left: 10px;">
                            <input class="mt-1" id="account_name" style="border-radius: 10px; padding: 5px; border: none;" value="{{ (Auth::user()->name && explode(' ', Auth::user()->name)[0]) ? explode(' ', Auth::user()->name)[0] : '' }}" placeholder="First name">
                            <input class="mt-1" id="account_surname" style="border-radius: 10px; padding: 5px; border: none;" value="{{ (Auth::user()->name && explode(' ', Auth::user()->name)[1]) ? explode(' ', Auth::user()->name)[1] : '' }}" placeholder="Last name">
                            <input class="mt-1" disabled id="account_email" style="border-radius: 10px; padding: 5px; border: none;" value="{{ (Auth::user()->email == 'guest443532@lavkaapp.com') ? '' : Auth::user()->email }}" placeholder="Email...">
                            <input class="mt-1" id="account_telephone" style="border-radius: 10px; padding: 5px; border: none;" value="{{ Auth::user()->phone ? Auth::user()->phone : '' }}" placeholder="Telephone">
                            <br />
                            @if (Auth::user()->email != 'guest443532@lavkaapp.com')
                                <button id="update_account_info" class="btn btn-secondary mt-1">Update</button>
                            @endif
                        </div>
                    </div>
                </div>

                <h3 style="text-align: center;">Orders</h3>

                <hr />

                <div class="row pr-1">
                    <span class="col media_font_size" style="text-align: center; color: grey;">Filters</span>
                    <span class="col media_font_size" style="text-align: center; color: grey;">
                        <select id="status_selector_id" style="border: 1px solid grey; border-radius: 10px;">
                            <option>All</option>
                            <option value="pending">Pending</option>
                            <option value="in_warehouse">In Warehouse</option>
                            <option value="on_the_way">On The Way</option>
                            <option value="delivered">Delivered</option>
                            <option value="completed">Completed</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </span>
                    <span class="col media_font_size" style="text-align: center; color: grey;">
                        <input id="searched_order_id" style="border: 1px solid grey; border-radius: 10px;" placeholder="Order Id" />
                    </span>
                    <span class="col media_font_size" style="text-align: center; color: grey;">
                        <button id="apply_filters_id" class="btn btn-link">Apply</button>
                    </span>
                </div>

                <hr />
                @if (count($orders) > 0)
                    @foreach ($orders as $x)
                        <div class="row media_font_size" style="border: 2px solid silver; border-radius: 10px; margin: 5px; margin-right: 0px; margin-bottom: 10px;">
                            <div class="col-1">
                                <span style="color: grey;">{{ $x->id }}</span>
                            </div>
                            <div class="col-3">
                                <span style="color: grey;">{{ $x->ordered_for_date }}</span>
                            </div>
                            <div class="col-2">
                                <span style="color: grey;">{{ $x->status }}</span>
                            </div>
                            <div class="col-3">
                                <span style="color: grey;">${{ $x->total_price }}</span>
                            </div>
                            <div class="col-2" style="">
                                <a href="javascript:void(0)">
                                    View
                                </a>
                                
                                <!--a href="javascript:void(0)">
                                    <img id="decrement_quantity" data-id="{{ $x }}" class="" src="{{ asset('images/icons/minus.png') }}" />
                                </a>
                                <input id="quantity_{{ $x }}" class="categoriesProductCountWidth" style="border: none; background-color: white;" type="number" value="0" disabled />
                                <a href="javascript:void(0)">
                                    <img class="" id="increment_quantity" data-id="{{ $x }}" src="{{ asset('images/icons/add.png') }}" />
                                </a-->
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 style="text-align: center; font-style: italic;">No orders yet!</h5>
                @endif
            </div>
        </div>
    </div>

    <form method="POST" style="visibility: none;">
        @csrf
    </form>
</div>
@endsection
