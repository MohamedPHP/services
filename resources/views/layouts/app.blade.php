<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta id="_token" value="{{ csrf_token() }}">

    <title>Services</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    {{ Html::style('frontend/css/style.css') }}

</head>
<body id="app-layout">
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
                    Services
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Orders <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a v-link="{ path: '/IncomingOrders' }"><i class="fa fa-btn fa-truck"></i>Incoming Orders</a></li>
                                <li><a v-link="{ path: '/PurchaseOrders' }"><i class="fa fa-btn fa-cart-plus"></i>Purchase Orders</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Services <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a v-link="{ path: '/AddService' }"><i class="fa fa-btn fa-plus"></i>Add Service</a></li>
                                <li><a v-link="{ path: '/MyServices' }"><i class="fa fa-btn fa-user"></i>My Services</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-btn fa-edit"></i>Edit Data</a></li>
                                <li><a href="#"><i class="fa fa-btn fa-money"></i>Balance</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')


    {{ Html::script('frontend/js/main.js') }}
    {{ Html::script('frontend/js/app.js') }}

</body>
</html>
