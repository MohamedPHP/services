<!DOCTYPE html>
<html>
<head>
    <title>Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- styles -->
    <link href="{{ asset('admin/css/main.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    @include('admin.layouts.includes.header')
    <div class="page-content">
        <div class="row">
            @include('admin.layouts.includes.sidebar')
            <div class="col-md-10" style="border-radius: 1px;box-shadow: 1px 1px 1px #ccc;border-top: 3px solid #a94442;padding-left: 15px;">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script type="text/javascript">
        $('.delete').click(function () {
            return confirm('Are You Sure? If You Delete This All The Data Related To It Will Be Removed');
        });
        $('.confirmed').click(function () {
            return confirm('Are You Sure?');
        });
        $('.alert').on('click', function() {
            $(this).hide();
        });
    </script>
    @yield('scripts')
</body>
</html>
