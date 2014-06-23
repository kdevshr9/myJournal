<html>
    <head>
        <title>{{ $title }}</title>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        {{ HTML::script('js/semantic.min.js'); }}
        {{ HTML::script('js/general.js'); }}
        
        
        {{ HTML::style('css/semantic.min.css'); }}
        {{ HTML::style('css/custom.css'); }}
    </head>
    <body>
<!--        <div class="ui secondary pointing menu">
            <a class="active item" href="{{ url('/') }}">
                <i class="home icon"></i> Home
            </a>
            <a class="item" href="{{ url('login') }}" >
                <i class="sign in icon"></i> Login
            </a>
            <a class="item" href="{{ url('register') }}" >
                <i class="archive icon"></i> Register
            </a>
            <div class="right menu">
                <div class="item">
                    <div class="ui icon input">
                        <input type="text" placeholder="Search...">
                        <i class="search link icon"></i>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="ui teal inverted menu">
            <a class="active item" href="{{ url('/') }}">
                <i class="home icon"></i> Home
            </a>
            @if(Auth::check())
                <a class="item" href="{{ url('profile') }}">
                    <i class="user icon"></i> Profile
                </a>
                <a class="item" href="{{ url('journal/create') }}">
                    <i class="add icon"></i> Add new Journal
                </a>
                <a class="item" href="{{ url('logout') }}">
                    <i class="sign out icon"></i> Logout
                </a>
            @else
                <a class="item" href="{{ url('login') }}">
                    <i class="sign in icon"></i> Login
                </a>
            @endif
        </div>

        <!-- check for flash notification message -->
        @if(Session::has('flash_notice'))
            <div class="ui floating message">{{ Session::get('flash_notice') }}</div>
        @endif
        
        @yield('content')
    </body>
</html>