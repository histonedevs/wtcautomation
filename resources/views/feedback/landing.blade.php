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

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <section id="main">
        <header>
            <img src="{{ $account->logo }}" alt="{{ $account->company_name }}" title="{{ $account->company_name }}"
                 style="max-width: 85%;" class="aligncenter size-full wp-image-3018"/>

            <div style="clear:both; margin-top:-30px;">&nbsp;</div>

            <h2>Thank you!</h2>
            @if(!empty($message->couponCode))
                <p>Here is Your Customer Appreciation Gift.<br/>Record this code for your next purchase:</p>
                <h1 style="text-decoration: underline;">{{ $message->couponCode }}</h1>
            @endif
            <br/><br/>

            <div style="clear:both; margin-top:-30px;">&nbsp;</div>

            <h2>Would you recommend us?</h2>
            <p>
                <a href="{{ url("/feedback/recommended/{$message->id}") }}" class="btn btn-primary">YES</a>
                <a href="{{ url("/feedback/rejected/{$message->id}") }}" class="btn btn-default">NO</a>
            </p>

            <br/>

            <label><input type="checkbox" name="agree" value="1"/> Agree to be contacted</label>

            <br/><br/>
        </header>
    </section>

</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">TERMS OF SERVICES</h4>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h2>ACCEPTANCE</h2>
                    <p>When you sign-in with us, you are giving (company) your permission and consent to send you email and/or SMS text messages. By checking the Terms and Conditions box and by signing in you automatically confirm that you accept all terms in this agreement.</p>

                    <h2>SERVICE</h2>
                    <p>This is a free service provided by us to our VIP clients of which you are included. We provide a service that currently allows you to receive requests for feedback, company information, promotional information, company alerts, coupons, discounts and other notifications to your email address and/or cellular phone or device. Email delivery is free of any charges. SMS will be subject to your regular SMS rates, most carriers now have free inbound SMS messages associated with the display or delivery of each SMS text message sent to you by us.</p>

                    <h2>YOUR REGISTRATION DATA</h2>
                    <p>You agree to provide true, accurate, current and complete information about yourself as prompted by the Service's registration form (such information being the "Registration Data").</p>

                    <h2>PRIVACY</h2>
                    <p>The information provided during this registration is kept private and confidential, and will never be distributed, copied, sold, traded or posted in any way, shape or form. This is our guarantee.</p>

                    <h2>DISCLAIMER OF WARRANTIES</h2>
                    <p>You expressly understand and agree that: No advice or information, whether oral or written, obtained by you from (company) or through or from the service shall create any warranty not expressly stated in the TOS.</p>

                    <h2>OPT-OUT</h2>
                    <p>You may at any time opt out of notices from (company) by the following two options:</p>
                    <ol>
                        <li>Email us at (company@company.com) with “Unsubscribe” in the subject line.</li>
                        <li>Text “Stop” to any message from us.</li>
                    </ol>

                    <p>By registering and subscribing to our email and SMS service, by opt-in, online registration or by filling out a card, "you agree to these TERMS OF SERVICE" and you acknowledge and understand the above Terms of Service outlined and detailed for you today.</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" role="button" class="btn btn-default" data-dismiss="modal" id="btn-decline" onclick="$('input:checkbox').removeAttr('checked')">Decline</a>
                <a href="#" role="button" class="btn btn-primary" data-dismiss="modal" id="btn-agree">Agree</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    if ('addEventListener' in window) {
        window.addEventListener('load', function () {
            document.body.className = document.body.className.replace(/\bis-loading\b/, '');
        });
        document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
    }

    $(document).ready(function(){
        $('input[type="checkbox"]').on('change', function(e){
            if(e.target.checked){
                $('#myModal').modal();
            }
        });
    });

</script>

@include("analytics")
</body>
</html>