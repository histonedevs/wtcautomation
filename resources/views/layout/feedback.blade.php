<!DOCTYPE HTML>
<!--
	Identity by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Thank You For Your Review!</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


    <!--[if lte IE 8]>
    <script src="{{ asset('assets/js/html5shiv.js') }}"></script>
    <script src="{{ asset('assets/js/respond.min.js') }}"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing/main.css') }}"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('assets/css/landing/ie9.css') }}"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{ asset('assets/css/landing/ie8.css') }}"/><![endif]-->
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/landing/noscript.css') }}"/>
    </noscript>
</head>
<body class="is-loading">

    @yield('page-content')

    @section('on-page-js')
        <!-- Scripts -->
        <script>
            if ('addEventListener' in window) {
                window.addEventListener('load', function () {
                    document.body.className = document.body.className.replace(/\bis-loading\b/, '');
                });
                document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
            }
        </script>
    @show

@include("analytics")

</body>
</html>