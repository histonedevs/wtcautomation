<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.theme.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.structure.min.css') }}" type="text/css">
</head>
<body>
<div class="container">
    @yield('content')
    @yield('show')
</div>
</body>
{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/bootstrap.datetimepicker.js') !!}
{!! Html::script('assets/js/jquery-ui.js') !!}
@yield('page-script');
</html>
