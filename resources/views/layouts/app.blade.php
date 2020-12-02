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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,700;1,400&display=swap" rel="stylesheet">

    @yield('styles')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-teal-200">
    <div id="app">
        <nav class="bg-teal-700 shadow-md py-6">
            <div class="container mx-auto md:px-0">
                <div class="flex items-center justify-around">
                    <a class="text-2xl text-white" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <nav class="flex-1 text-right">
                        @guest
                        <a class="text-white no-underline hover:underline hover:text-teal-400"
                            href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                        <a class="text-white no-underline hover:underline hover:text-teal-400"
                            href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                        @else
                        <span class="text-teal-400 text-sm pr-4">{{ Auth::user()->name }} </span>

                        <a href="{{ route('notificaciones')}}"
                            class="bg-teal-500 rounded-full mr-2 px-4 py-1 font-bold text-sm text-white">{{ Auth::user()->unreadNotifications->count() }}</a>

                        <a class="no-underline hover:underline text-teal-400 text-sm p-3" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @endguest
                    </nav>

                </div>
            </div>
        </nav>

        <div class="bg-teal-500">
            <nav class="container mx-auto flex flex-col text-center md:flex-row space-x-1">
                @yield('navegacion')
            </nav>
        </div>

        @if (session('estado'))
        <div class="bg-blue-500 p-8 text-center text-white font-bold uppercase">
            {{session('estado')}}
        </div>
        @endif

        <main class="mt-10 container mx-auto">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>

</html>
