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

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <section id="main">
        <header>
            <img src="{{ $account->logo }}" alt="{{ $account->company_name }}" title="{{ $account->company_name }}"
                 style="max-width: 300px" class="aligncenter size-full wp-image-3018"/>

            <div style="clear:both; margin-top:-30px;">&nbsp;</div>
            <h3>Click below to play the video:</h3>
            <iframe width="100%" height="200" src="https://www.youtube.com/embed/0w0mfxjoHsc?rel=0&showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>
            <br><br>
            <p>
                <a href="https://www.amazon.com/review/review-your-purchases?ie=UTF8&asins={{ $asin }}&channel=awReviews&ref_=aw_cr_write_cr#" style="text-decoration:none; color:#000000;">
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <br>
                    <span style="font-size:18px;font-weight:bold;">I love it</span>
                </a>
            </p>
            <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
            <p>
                <a href="https://www.amazon.com/review/review-your-purchases?ie=UTF8&asins={{ $asin }}&channel=awReviews&ref_=aw_cr_write_cr#" style="text-decoration:none; color:#000000;">
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="4" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <br>
                    <span style="font-size:18px;font-weight:bold;">I like it</span>
                </a>
            </p>
            <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
            <p>
                <a href="https://www.amazon.com/gp/help/contact/contact.html?ie=UTF8&asin={{ $asin }}&isCBA=&marketplaceID={{ $marketplace_id }}&orderID=&ref_=aag_d_sh&sellerID={{ $seller_id }}" style="text-decoration:none; color:#000000;">
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="3" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <br>
                    <span style="font-size:18px;font-weight:bold;">It's ok</span>
                </a>
            </p>
            <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
            <p>
                <a href="https://www.amazon.com/gp/help/contact/contact.html?ie=UTF8&asin={{ $asin }}&isCBA=&marketplaceID={{ $marketplace_id }}&orderID=&ref_=aag_d_sh&sellerID={{ $seller_id }}" style="text-decoration:none; color:#000000;">
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="2" width="30px;" height="29px;"/>
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                    <br>
                    <span style="font-size:18px;font-weight:bold;">I don't like it</span>
                </a>
            </p>
            <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
            <p>
                <a href="https://www.amazon.com/gp/help/contact/contact.html?ie=UTF8&asin={{ $asin }}&isCBA=&marketplaceID={{ $marketplace_id }}&orderID=&ref_=aag_d_sh&sellerID={{ $seller_id }}" style="text-decoration:none; color:#000000;">
                    <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="1" width="30px;" height="29px;"/>
                    <br>
                    <span style="font-size:18px;font-weight:bold;">I hate it</span>
                </a>
            </p>
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
@include("analytics")
</body>
</html>