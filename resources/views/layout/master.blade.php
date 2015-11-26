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
                    <li>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Users<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('users/add') }}">Add User</a></li>
                            <li><a href="{{ url('users/index')  }}">Display All Users</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url ('home')}}">Download</a></li>
                    <li><a href="{{ url ('users/sms') }}">Send Sms</a></li>
                </ul>
            </div>
            <a href="{{  url('auth/logout')  }}" class="navbar-link btn btn-default pull-right" style="margin-top:5px;">Sign Out</a>
            <span style="float:right;margin-top:10px; margin-right:10px;">{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}</span>
        </div>
    </nav>

    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @yield('content')
    @yield('show')
</div>
</body>
{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/bootstrap-datetimepicker.js') !!}
{!! Html::script('assets/js/jquery-ui.js') !!}
@yield('page-script');
<script>
    $(document).ready(function () {
        var url = window.location;
        $('ul.nav a[href="' + url + '"]').parent().addClass('active');
        $('ul.nav a').filter(function () {
            return this.href == url;
        }).parent().addClass('active').parent().parent().addClass('active');
    });
</script>
</html>
