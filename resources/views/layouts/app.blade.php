<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript">

        function destroySession(){
            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: '{{URL::to('removeSession')}}',
            });
        }

    </script>
    
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-default navbar-fixed-top" style="background-color: 18BC9C; ">
            <div class="container" >
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="color: white;">
                        {{ config('app.name', "Todays Technology") }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                      
                            @if(Session::has('id'))
                                <li ><a href='{{ action("PagesController@home") }}' style="color: white;">Home</a></li>
                                <li><a href='{{ action("PagesController@profile") }}' style="color: white;">Profile</a></li>
                                <li onclick="destroySession()"><a href="{{ action("PagesController@login") }}" style="color: white;">Logout</a></li>
                            @else
                                <li><a href='{{ action("PagesController@login") }}' style="color: white;">Login</a></li>
                                <li><a href='{{ action("PagesController@userregistration") }}' style="color: white;">Register</a></li>

                            @endif
                      
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
