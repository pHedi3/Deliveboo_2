<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://js.braintreegateway.com/web/dropin/1.32.0/js/dropin.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        <nav style="background-color: #e1dd8f;" class="navbar navbar-expand-md navbar-light ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="/img/logo_small.png" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item login">
                                <a style="color: #8e3b46; font-size:20px" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item register">
                                    <a style="color: #8e3b46; font-weight:800; font-size:20px" class="nav-link" href="{{ route('register') }}">Collabora con noi</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: #8e3b46; font-weight:800; font-size:20px" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="/dashboard">Vai alla Tua Dashboard</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    
                </div>
            </div>
        </nav>
        @if (Auth::check()) 
            <meta name="user_id" content="{{ Auth::user()->id }}" />
            @else <meta name="user_id" content="null" /> 
        @endif

        <main >
            @yield('content')
        </main>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 box-content">
                        <div class="box-footer">
                            <div class="list-footer">Discover Deliveroo</div>
                            <div class="list-footer"><a href="#">Investitori</a></div>
                            <div class="list-footer"><a href="#">Chi siamo</a></div>
                            <div class="list-footer"><a href="#">Ristoranti</a></div>
                            <div class="list-footer"><a href="#">Altro</a></div>
                            <div class="list-footer"><a href="#">Pressroom</a></div>
                            <div class="list-footer"><a href="#">Il nostro blog</a></div>
                            <div class="list-footer"><a href="#">Programmazione</a></div>
                            <div class="list-footer"><a href="#">Design</a></div>
                            <div class="list-footer"><a href="#">Lavora con noi</a></div>
                            <div class="list-footer"><a href="#">Diventa nostro partner</a></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 box-content">
                        <div class="box-footer">
                            <div class="list-footer">Note Legali</div>
                            <div class="list-footer"><a href="#">Termini & condizioni</a></div>
                            <div class="list-footer"><a href="#">Informativa sulla privacy</a></div>
                            <div class="list-footer"><a href="#">Cookies</a></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 box-content">
                        <div class="box-footer">
                            <div class="list-footer">Aiuto</div>
                            <div class="list-footer"><a href="#">Contatti</a></div>
                            <div class="list-footer"><a href="#">FAQ</a></div>
                            <div class="list-footer"><a href="#">Tipi di cucina</a></div>
                            <div class="list-footer"><a href="#">Mappa del sito</a></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 box-content">
                        <div class="box-footer">
                            <div class="list-footer">Porta Deliveroo con te</div>
                            <div class="img-footer">
                                <a href="#"><img src="./img/appstorefooter.png" width="150" alt=""></a>
                            </div>
                            <div class="img-footer">
                                <a href="#"><img src="./img/appstorefooter2.png" width="150"alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 bottom-footer">
                        <div class="left-bottom-footer">
                            <span class="icon-footer"><a href="#"><i class="fab fa-facebook"></i></a></span>
                            <span class="icon-footer"><a href="#"><i class="fab fa-twitter"></i></a></span>
                            <span class="icon-footer"><a href="#"><i class="fab fa-instagram"></i></a></span>
                        </div>
                        <div class="rigth-bottom-footer">
                            <span><i class="far fa-copyright"></i> 2021 Deliveroo</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>


<style>
    .logo{
        width: 200px;
    }

    nav{
        background-color: #e1dd8f;
    }

</style>