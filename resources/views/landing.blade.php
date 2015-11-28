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

    <!--[if lte IE 8]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.min.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ URL::asset('assets/css/landing/main.css') }}"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/landing/ie9.css') }}"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/landing/ie8.css') }}"/><![endif]-->
    <noscript>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/landing/noscript.css') }}"/>
    </noscript>
</head>
<body class="is-loading">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <section id="main">
        <header>

            <img src="http://worldtradeconcierge.com/wp-content/uploads/2015/11/Lamborghini-logo.png"
                 alt="logo-island-miracle" width="250" height="59" class="aligncenter size-full wp-image-3018"/>

            <h1>Thank You For Your Review!</h1>

            <iframe src="https://www.youtube.com/embed/d_VYJWHc5Pk?rel=0" frameborder="0" allowfullscreen></iframe>
            <br><br>

            <p>
                <a href="https://www.amazon.com/review/review-your-purchases?ie=UTF8&asins={{$asin}}&channel=awReviews&ref_=aw_cr_write_cr&#"
                   style="text-decoration:none; color:#000000;">
                    <img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5" width="21px;"
                            height="20px;"/><br>I love it</a></p>

            <p>
                <a href="https://www.amazon.com/review/review-your-purchases?ie=UTF8&asins={{$asin}}&channel=awReviews&ref_=aw_cr_write_cr&#"
                   style="text-decoration:none; color:#000000;"><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="4" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><br>I like it</a></p>

            <p><a href="http://www.amazon.com/gp/orc/returns/homepage.html"
                  style="text-decoration:none; color:#000000;"><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="3" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5" width="21px;"
                            height="20px;"/><br>It's ok</a></p>

            <p><a href="http://www.amazon.com/gp/orc/returns/homepage.html"
                  style="text-decoration:none; color:#000000;"><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="2" width="21px;"
                            height="20px;"/><img src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="5"
                                                 width="21px;" height="20px;"/><br>I don't like it</a></p>

            <p><a href="http://www.amazon.com/gp/orc/returns/homepage.html"
                  style="text-decoration:none; color:#000000;"><img
                            src="{{ URL::asset('assets/css/landing/images/star_yellow.png') }}" alt="1" width="21px;"
                            height="20px;"/><br>I hate it</a></p>

        </header>
    </section>
</div>

<!-- Scripts -->
<script>
    if ('addEventListener' in window) {
        window.addEventListener('load', function () {
            document.body.className = document.body.className.replace(/\bis-loading\b/, '');
        });
        document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
    }
</script>

</body>
</html>