<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" 
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if (!Route::is('splash') && !Route::is('login') && !Route::is('register') && !Route::is('without_register') && !Route::is('admin-login'))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="">
                <div class="container">
                    <a class="navbar-brand col-3" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    
                    <div class="col-8">
                        <div class="row">
                            <div class="col-10">
                                @if (!Route::is('account'))
                                    <span style="color: grey;">Shopping for </span>
                                    <input type="date" id="delivery_date_input" style="padding: 5px; border-radius: 10px; border: 1px solid silver; color: grey;" />
                                @endif
                            </div>

                            <div class="col-2 mt-md-2 mt-4">
                                <a href="#">
                                    <img id="header_search_icon" src="{{ asset('images/icons/loupe_2.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </nav>
        @endif

        <main class="py-4" style="">
            @yield('content')
        </main>

        @if (!Route::is('splash') && !Route::is('login') && !Route::is('register') && !Route::is('without_register') && !Route::is('admin-login'))
            <div class="row mobile_footer">
                <div class="col-md-6 offset-md-3 col-12">
                    <a href="{{ route('home') }}" class="ml-2 mr-2">
                        <div style="text-align: center; display: inline-block;">
                            <img id="menu_home_page" src="{{ asset('images/icons/home.png') }}" />
                            <span class="menu_item_capture" style="display: block;">Home</span>
                        </div>
                    </a>
                    <a href="{{ route('categories') }}" class="mr-2 ml-2">
                        <div style="text-align: center; display: inline-block;">
                            <img id="menu_categories_page" src="{{ asset('images/icons/categories.png') }}" />
                            <span class="menu_item_capture" style="display: block;">Categories</span>
                        </div>
                    </a>
                    <!--a href="{{ route('cart') }}" class="mr-2 ml-2"-->
                    <a href="javascript:void(0)" class="mr-2 ml-2">
                        <div style="text-align: center; display: inline-block;">
                            <img id="menu_cart_page" src="{{ asset('images/icons/cart.png') }}" />
                            <span id="menu_item_capture_id" class="menu_item_capture" style="display: block;">Cart</span>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="ml-2">
                        <div style="text-align: center; display: inline-block;">
                            <img id="menu_account_page" src="{{ asset('images/icons/profile.png') }}" />
                            <span class="menu_item_capture" style="display: block;">Account</span>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
        integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
        crossorigin="anonymous" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
</body>
</html>
