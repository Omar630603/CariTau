<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CariTau') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Icon -->
    <link rel="icon" href="{{ asset('storage/images/ICON.png') }}">
</head>

<body class="antialiased">
    <nav style="display: flex;" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand profile-logo" href="{{ url('/') }}">
                <img align="center" height="30" width="80" src="{{ asset('storage/images/ICON2.png') }}" alt="">
            </a>
            <button class="navbar-toggler profile-logo" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                </ul>
                <!-- Middle Side Of Navbar -->
                <nav class="shift"style="padding: 0">
                    <ul class="navbar-nav md-auto">
                        <li><a href="/">Home</a></li>
                        <li><a href="{{route('aboutUs')}}">About Us</a></li>
                        <li><a href="{{route('courses')}}">Courses</a></li>
                        <li><a href="{{route('lecturers')}}">Lecturers</a></li>
                        <li><a href="{{route('contactUs')}}">Contact Us</a></li>
                    </ul>
                </nav>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li>
                        @auth
                        @else
                        <a href="{{ route('login') }}" class="btn btn-dark" data-toggle="tooltip"
                        title="login"><i class="fa fa-sign-in"
                                aria-hidden="true"></i></a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-dark" data-toggle="tooltip"
                        title="register"><i class="fa fa-address-book-o"
                                aria-hidden="true"></i></a>
                        @endif
                        @endauth
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <div class="profile-logo" style="display: flex; justify-content: space-between;">
                            <div style="display: flex; flex-direction: column;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('home') }}" class="dropdown-item">Dashboard <i style="margin-top: 4px"
                                            class="fa fa-dashboard float-right" aria-hidden="true"></i></a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} <i style="margin-top: 4px" class="fa fa-sign-out float-right" aria-hidden="true"></i>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('admin.userDetails', Auth::user()->ID_user) }}"><img width="35px"
                                    height="35px" style="border-radius: 50%"
                                    src="{{asset('storage/'.Auth::user()->image)}}"></a>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
<footer class="footer-16371">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center">
                <div class="footer-site-logo mb-4">
                    <a href="#">CariTau</a>
                </div>
                <ul class="list-unstyled nav-links mb-4">
                    <li><a href="/">Home</a></li>
                    <li><a href="{{route('aboutUs')}}">About Us</a></li>
                    <li><a href="{{route('courses')}}">Courses</a></li>
                    <li><a href="{{route('lecturers')}}">Lecturers</a></li>
                    <li><a href="{{route('contactUs')}}">Contact Us</a></li>
                </ul>
                <div class="social mb-2">
                    <h3>Stay in touch</h3>
                    <ul class="list-unstyled nav-links">
                        <li class="in"><a href="#"><span class="icon-instagram"></span></a></li>
                        <li class="fb"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="tw"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="pin"><a href="#"><span class="icon-pinterest"></span></a></li>
                        <li class="dr"><a href="#"><span class="icon-dribbble"></span></a></li>
                    </ul>
                </div>
                <div class="copyright">
                    <p class="font-italic text-muted mb-0">&copy; Copyrights CariTau.com All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</html>