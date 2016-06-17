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
    <section id="main" class="col-sm-9 col-md-9">
        <header>
            <img src="{{ $account->logo }}" alt="{{ $account->company_name }}" title="{{ $account->company_name }}"
                 style="max-width: 85%;" class="aligncenter size-full wp-image-3018"/>

            <div class="col-sm-6 col-md-6">
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/fG3SDgWezNg?rel=0&showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>

                <p>We are really sorry your experience was not great.</p>
                <p>Our company is focused on every customer and client having a first class experience. Unfortunately, sometimes companies make mistakes and it looks like your experience wasn't as good as we would like it to be.</p>
                <p>We want the opportunity to correct our mistake. Please contact us directly and let us know how we can turn your negative experience into a 5-star first class experience.</p>

                @if(!empty($account->company_name))
                    <a href="#" role="button" class="btn btn-default">{{ $account->company_name }}</a>
                @endif
            </div>

            <div class="col-sm-6 col-md-6">
                <h2>We Apologize... How Can We Improve?</h2>
                <br>
                {!! Form::open(array('url' => 'feedback/send-feedback', 'method' => 'POST')) !!}
                    <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                        <label class="control-label">1. What happened that was unsatisfactory?</label>
                        <textarea class="form-control" rows="3" name="reason" ></textarea>
                    </div>

                    <div class="form-group{{ $errors->has('suggestion') ? ' has-error' : '' }}">
                        <label class="control-label">2. How can we make it better so this won’t happen again?</label>
                        <textarea class="form-control" rows="3" name="suggestion"></textarea>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">3. First & Last Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" />
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">4. Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="message_id" value="{{$message_id}}"/>
                        <button type="submit" class="btn btn-primary">Send This To The Manager</button>
                    </div>
                {!! Form::close() !!}
            </div>
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