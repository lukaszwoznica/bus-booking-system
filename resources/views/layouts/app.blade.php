<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<div id="app">
    <nav class="navbar navbar-expand-md {{ request()->routeIs('home', 'login', 'register')
                                            ? 'navbar-dark navbar-transparent'
                                            : 'navbar-light bg-dark shadow-sm' }}">

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-fw fa-bus"></i>
                {{ ucwords(config('app.name', 'Laravel')) }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @isAdmin
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Admin panel
                                    </a>
                                @endisAdmin

                                <a class="dropdown-item" href="{{ route('bookings.index') }}">
                                    My bookings
                                </a>

                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    Profile settings
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if(request()->routeIs('home', 'login', 'register'))
        <div class="video-background-wrapper">
            <video src="{{ asset('videos/background.mp4') }}" muted loop autoplay
                   poster="{{ asset('images/video-background-poster.png') }}">
            </video>
            <div class="overlay"></div>
        </div>
    @endif

    @yield('inactive-account-alert')

    <main class="py-4">
        @yield('content')
    </main>
</div>

@yield('scripts')

</body>
</html>
