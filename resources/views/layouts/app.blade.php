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






    @yield('content')





    <script>
        var userIsLoggedIn = '{{ Auth::check() }}';
    </script>
    {{ Html::script('frontend/js/main.js') }}
    {{ Html::script('frontend/js/app.js') }}
</body>
</html>
