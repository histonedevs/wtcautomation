@extends('layout.feedback')

@section('page-content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main">
            <header>
                <img src="{{ $account->logo }}" alt="{{ $account->company_name }}" title="{{ $account->company_name }}"
                     style="max-width: 85%;" class="aligncenter size-full wp-image-3018"/>

                <div style="clear:both; margin-top:-30px;">&nbsp;</div>
                <h3>Click below to play the video:</h3>
                @if(!empty($account->video_link_pos_response))
                    {!! $account->video_link_pos_response !!}
                @else
                    <iframe width="100%" src="https://www.youtube.com/embed/0w0mfxjoHsc?rel=0&showinfo=0&autoplay=1"
                            allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen"
                            msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen"
                            webkitallowfullscreen="webkitallowfullscreen"></iframe>
                @endif

                <br><br>
                <p>
                    <a href="{{ url("v/{$message_id}/5") }}" style="text-decoration:none; color:#000000;">
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
                    <a href="{{ url("v/{$message_id}/4") }}" style="text-decoration:none; color:#000000;">
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
                    <a href="{{ url("v/{$message_id}/3") }}" style="text-decoration:none; color:#000000;">
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="3" width="30px;" height="29px;"/>
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                        <br>
                        <span style="font-size:18px;font-weight:bold;">It's ok</span>
                    </a>
                </p>
                <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
                <p>
                    <a href="{{ url("v/{$message_id}/2") }}" style="text-decoration:none; color:#000000;">
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="2" width="30px;" height="29px;"/>
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="5" width="30px;" height="29px;"/>
                        <br>
                        <span style="font-size:18px;font-weight:bold;">I don't like it</span>
                    </a>
                </p>
                <div style="margin-top:-30px; margin-bottom:-30px;"><hr></div>
                <p>
                    <a href="{{ url("v/{$message_id}/1") }}" style="text-decoration:none; color:#000000;">
                        <img src="{{ asset('assets/css/landing/images/full_star.png') }} " alt="1" width="30px;" height="29px;"/>
                        <br>
                        <span style="font-size:18px;font-weight:bold;">I hate it</span>
                    </a>
                </p>

                <br/>
                <h4>Email me this to do on my computer:</h4>
                {!! Form::open(array('url' => 'feedback/email-feedback', 'method' => 'POST', 'class' => 'form-inline')) !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" placeholder="Email" class="form-control" />
                        <input type="hidden" name="message_id" value="{{$message_id}}"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                {!! Form::close() !!}

            </header>
        </section>
    </div>

@endsection
