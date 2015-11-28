<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}" type="text/css"/>
</head>
<body>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-5">
            <div>
                <img src="{{ URL::asset('assets/images/product.jpg') }}" alt="logo" class="img-thumbnail" width="200"
                     height="200">
            </div>
            <div class="caption">
                <h3>{{ $product->title }}</h3>
                <p>Thanks For Buying...</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            <iframe width="420" height="315"
                    src="http://www.youtube.com/embed/XGSy3_Czz8k?autoplay=1?controls=2">
            </iframe>
        </div>
    </div>
</div>
{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
</body>
</html>
