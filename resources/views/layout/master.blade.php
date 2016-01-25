<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title' , "WTC Dialler Automation")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,fc-3.1.0,fh-3.0.0,r-1.0.7/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.0/css/colReorder.dataTables.min.css">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.min.css') }}" type="text/css"/>
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
                    @if(Auth::user()->user_type == 'admin' OR Auth::user()->user_type == 'supervisor')
                        <li>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Users<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('users')  }}">All Users</a></li>
                                <li><a href="{{ url('users/add') }}">Add User</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Campaigns<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url ('campaigns') }}">All Campaigns</a></li>
                                <li><a href="{{ url ('campaigns/add') }}">Add Campaign</a></li>
                                <li><a href="{{ url ('campaigns/import-csv') }}">Import Campaign</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url ('accounts') }}">Accounts</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url ('settings/campaign-sms-text') }}">Campaigns SMS Text</a></li>
                            </ul>
                        </li>
                        @if(Auth::user()->user_type == 'admin')
                            <li>
                                <a href="{{ url ('sms/index') }}">Messages</a>
                            </li>
                            <li>
                                <a href="{{ url ('sms/industry-first') }}" >Industry First</a>
                            </li>
                        @endif
                    @elseif(Auth::user()->user_type == 'operator')
                        <li>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Campaigns<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url ('campaigns') }}">All Campaigns</a></li>
                            </ul>
                        </li>
                    @endif
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

{!! Html::script('assets/js/moment.js') !!}
{!! Html::script('assets/js/bootstrap-datetimepicker.js') !!}

<script>
    var APP_URL = '{{ url('/') }}';
    $('ul.nav a[href="' + window.location + '"]').parents("li").addClass('active');

    function getRowData (tbl_name, row) {
        if(tbl_name in window.LaravelDataTables){
            return window.LaravelDataTables[tbl_name].row(row).data();
        }
        return false;
    }
</script>
@yield('page-script')
@include("analytics")
</body>
</html>
