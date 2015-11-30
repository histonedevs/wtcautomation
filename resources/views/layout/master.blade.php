<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,fc-3.1.0,fh-3.0.0,r-1.0.7/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.0/css/colReorder.dataTables.min.css">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}" type="text/css" />
    {{--<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.min.css') }}" type="text/css"/>--}}
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
                            <li><a href="{{ url('users')  }}">All Users</a></li>
                            <li><a href="{{ url('users/add') }}">Add User</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url ('download')}}">Download</a></li>
                    <li><a href="{{ url ('sms') }}">Send Sms</a></li>
                    <li>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Campaigns<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url ('campaigns') }}">All Campaigns</a></li>
                            <li><a href="{{ url ('campaigns/add') }}">Add Campaign</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Accounts<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url ('accounts') }}">All Accounts</a></li>
                            <li><a href="{{ url ('accounts/csv') }}">Update Accounts</a></li>
                        </ul>
                    </li>
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
        <div class="alert alert-success">
            {{ Session::get('success') }}</div>
    @endif

    @yield('content')
    @yield('show')
</div>

{!! Html::script('assets/js/jquery.js') !!}

<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,fc-3.1.0,fh-3.0.0,r-1.0.7/datatables.min.js"></script>

{!! Html::script('assets/js/jquery-ui.js') !!}
<script>
    var APP_URL = '{{ url('/') }}';
    $('ul.nav a[href="' + window.location + '"]').parents("li").addClass('active');
</script>
@yield('page-script')
</body>
</html>
