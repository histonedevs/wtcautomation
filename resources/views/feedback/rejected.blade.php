@extends('layout.feedback')

@section('page-content')
    <style>
        @media screen and (min-width: 768px){
            #main{
                height: 900px;
            }
        }
    </style>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" style="width: 800px">
            <header style="margin-bottom: 25px;">
                <img src="{{ $account->logo }}" alt="{{ $account->company_name }}" title="{{ $account->company_name }}"
                     style="max-width: 85%;" class="aligncenter size-full wp-image-3018"/>

            </header>

                <div class="col-sm-6 col-md-6">
                    @if(!empty($account->video_link_neg_response))
                        {!! $account->video_link_neg_response !!}
                    @else
                        <iframe width="100%" src="https://www.youtube.com/embed/fG3SDgWezNg?rel=0&showinfo=0&autoplay=1"
                                allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen"
                                msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen"
                                webkitallowfullscreen="webkitallowfullscreen"></iframe>
                    @endif

                    <p>We Apologize that we let you down.</p>
                    <p>How Can We Improve?</p>
                    <p>Please help us learn how we can turn this negative, into a 5-star first-class experience for you!</p>

                    @if(!empty($account->company_name))
                        <p><strong>{{ $account->company_name }}</strong></p>
                    @endif
                </div>

                <div class="col-sm-6 col-md-6">
                    {!! Form::open(array('url' => 'feedback/send-feedback', 'method' => 'POST')) !!}
                        <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                            <label class="control-label">What happened that was unsatisfactory?</label>
                            <textarea class="form-control" rows="3" name="reason" ></textarea>
                        </div>

                        <div class="form-group{{ $errors->has('suggestion') ? ' has-error' : '' }}">
                            <label class="control-label">How can we make it better so this won’t happen again?</label>
                            <textarea class="form-control" rows="3" name="suggestion"></textarea>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">First & Last Name</label>
                            <input type="text" name="name" placeholder="Name" class="form-control" />
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" placeholder="Email" class="form-control" />
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="message_id" value="{{$message_id}}"/>
                            <button type="submit" class="btn btn-primary">Send This To The Manager</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            <div style="width: 100%; float: left">&nbsp;</div>
        </section>
    </div>

@endsection