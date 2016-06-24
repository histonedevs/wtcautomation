@extends('layout.feedback')

@section('page-content')

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" class="col-sm-9 col-md-9">
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

                    <p>We are really sorry your experience was not great.</p>
                    <p>Our company is focused on every customer and client having a first class experience. Unfortunately, sometimes companies make mistakes and it looks like your experience wasn't as good as we would like it to be.</p>
                    <p>We want the opportunity to correct our mistake. Please contact us directly and let us know how we can turn your negative experience into a 5-star first class experience.</p>

                    @if(!empty($account->company_name))
                        <p><strong>{{ $account->company_name }}</strong></p>
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

        </section>
    </div>

@endsection