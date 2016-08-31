<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.styles.css')}}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    @yield('styles')

    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

 @if (Auth::check())

    <header class="admin-header">
        <div class="container">
            <div class="col-md-6 left-side">
                <ul class="left-menu list-inline">
                    <li><a href="#" class="site-logo">WeAfrican Admin</a></li>
                </ul>
            </div>
            <div class="col-md-6 right-side">
                <ul class="list-inline">
                    {{--<li class="login"><a class="btn btn-success" href="{{url('/')}}">Visit Site</a></li>--}}
                    <li><a class="btn btn-danger" href="{{ url('logout') }}"><i class="fa fa-power-off"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="col-md-3">
        @include('admin.includes.leftmenu')
    </div>

    <div class="col-md-9">
    @endif
        <div id="page-content-wrapper" class="admin-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @if(Auth::check())
    </div>
    @endif

    @yield('scripts')
</body>
</html>
