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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">WTC</a>
            </div>
            <div>
                <ul class="nav navbar-nav dropdown">
                    <li class="active">
                        <a href="#" href="#" data-toggle="dropdown" class="dropdown-toggle">Users<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/user')  }}">Add User</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url ('/home')}}">Download</a></li>
                </ul>
            </div>
            <a href="{{  url('auth/logout')  }}" class="navbar-link btn btn-default pull-right">Sign Out</a>
        </div>
    </nav>

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
