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
    {{-- <nav class="navbar navbar-default navbar-static-top">
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
                    <li><a v-link="{ path: '/' }">Home</a></li>
                    <li><a v-link="{ path: '/Categories' }">Categories</a></li>
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
                                <i class="fa fa-envelope" aria-hidden="true"></i> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a v-link="{name: '/Inbox'}"><i class="fa fa-inbox"></i> Inbox</a>
                                </li>
                                <li>
                                    <a v-link="{name: '/SentMessages'}"><i class="fa fa-send"></i> Sent Messages</a>
                                </li>
                                <li>
                                    <a v-link="{name: '/UnreadMessages'}"><i class="fa fa-eye-slash"></i> Unread Messages</a>
                                </li>
                                <li>
                                    <a v-link="{name: '/ReadMessages'}"><i class="fa fa-eye"></i> Read Messages</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-money" aria-hidden="true"></i> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a v-link="{ path: '/AddCredit' }"><i class="fa fa-btn fa-exchange"></i>Charge Balance</a></li>
                                <li><a v-link="{ path: '/AllCharges' }"><i class="fa fa-btn fa-check"></i>My Charges</a></li>
                                <li><a v-link="{ path: '/AllPayments' }"><i class="fa fa-btn fa-money"></i>AllPayments</a></li>
                                <li><a v-link="{ path: '/Profits' }"><i class="fa fa-btn fa-plus-circle"></i>Profits</a></li>
                                <li><a v-link="{ path: '/Balance' }">Balance</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            @include('layouts.notifications')
                        </li>
                        <li>
                            <a v-link="{name: '/Wishlist'}">
                                <i class="fa fa-heart"></i>
                                <span class="label label-danger calc">{{ getCountWishlistItems(Auth::user()->id) }}</span>
                            </a>
                        </li>
                        <li>
                            <a v-link="{name: '/Inbox'}">
                                <i class="fa fa-inbox"></i>
                                <span class="label label-warning calc">{{ getCountInboxMessages(Auth::user()->id) }}</span>
                            </a>
                        </li>
                        <li>
                            <a v-link="{ path: '/IncomingOrders' }">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="label label-primary calc">{{ getCountIncomingOrders(Auth::user()->id) }}</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-btn fa-edit"></i>Edit Data</a></li>
                                <li><a href="#"><i class="fa fa-btn fa-money"></i>Balance</a></li>
                                <li><a v-link="{ path: '/AddCredit' }"><i class="fa fa-btn fa-exchange"></i>Charge Balance</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav> --}}


    @yield('content')


    {{-- <footer>
        <div class="footer" id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h3>Contact</h3>
                        <ul>
                            <li> <a href="#"> Lorem Ipsum </a> </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3> Important Links </h3>
                        <ul>
                            <li> <a href="#"> Admission </a> </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3> Location </h3>
                        <ul>
                            <li> <a href="#"> Lorem Ipsum </a> </li>
                        </ul>
                    </div>
                </div>
                <!--/.row-->
            </div>
            <!--/.container-->
        </div>
        <!--/.footer-->
    </footer> --}}


    {{ Html::script('frontend/js/main.js') }}
    {{ Html::script('frontend/js/app.js') }}
</body>
</html>
