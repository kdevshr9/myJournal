<html>
    <head>
        <title>{{ $title }}</title>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        {{ HTML::script('js/semantic.min.js'); }}
        
        
        {{ HTML::style('css/semantic.min.css'); }}
    </head>
    <body>
        <div class="ui secondary pointing menu">
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
        </div>

        @yield('content')
    </body>
</html>