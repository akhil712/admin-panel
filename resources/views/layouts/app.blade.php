<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Techsaga CRM') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        #logo {
            max-width: 110px;
        }

        nav {
            z-index: 1050;
            height: 56px !important;
        }

        .offcanvas-start {
            top: 56px !important;
            width: 180px !important;
        }

        .mandatory-field::after {
            content: "*";
            color: red;
            margin-left: 5px;
        }

        #menu-btn:hover,
        #menu-btn.opened {
            background: var(--bs-primary);
        }

        #menu-btn:hover i,
        #menu-btn.opened i {
            color: var(--bs-white);
        }

        #menu-btn i {
            color: var(--bs-primary);
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            @auth
                <button id="menu-btn" class="btn border-primary mx-5" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
            @endauth
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img id="logo" src="{{ asset('images/logo.webp') }}" alt="TechsagaCRM">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <!-- Offcanvas Menu -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
                {{-- <button type="button" class="btn-close" disabled aria-label="Close"></button> --}}
                <div class="offcanvas-body">
                    <ul class="list-group">
                        <li class="list-group-item  {{ Route::is('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        @foreach (Helper::createMenu() as $item)
                            @php
                                $routeParent = explode('.', $item)[0];
                            @endphp
                            <li class="list-group-item  {{ Route::is($routeParent . '.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route($item) }}"> {{ Helper::createMenuItemName($item) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endauth
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"
        integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        $('#offcanvasMenu').on('shown.bs.offcanvas', function() {
            $('#menu-btn').addClass('opened');
        });
        $('#offcanvasMenu').on('hidden.bs.offcanvas', function() {
            $('#menu-btn').removeClass('opened');
        });
    </script>
    @yield('scripts')
</body>

</html>
