<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{--<link href="/css/app.css" rel="stylesheet">--}}

    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=e15ef9974671fabf87bfe28ca05e8631&libraries=services,clusterer"></script>

    @yield('style')
    <!-- Scripts -->
    <script>
//        $current* 변수들 AppServiceProvider 에 등록 되어있다
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'currentUser' => $currentUser,
            'currentRouteName' => $currentRouteName,
            'currentLocale' => $currentLocale,
            'currentUrl' => $currentUrl,
        ]); ?>

    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">로그인</a></li>
                            <li><a href="{{ url('/register') }}">회원가입</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div>
            @include('flash::message')
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    {{--<script src="/js/app.js"></script>--}}
    <script src="{{ elixir('js/app.js') }}"></script>

    @yield('script')
</body>
</html>
