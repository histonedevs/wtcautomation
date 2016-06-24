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

                <h2>Thank you!</h2>
                @if(!empty($message->couponCode))
                    <p>Here is Your Customer Appreciation Gift.<br/>Record this code for your next purchase on Amazon:</p>
                    <h1 style="text-decoration: underline;">{{ $message->couponCode }}</h1>
                @endif
                <br/><br/>

                <div style="clear:both; margin-top:-30px;">&nbsp;</div>

                <h2>Would you recommend us?</h2>
                <p>
                    <a href="{{ url("/feedback/recommended/{$message->id}") }}" class="btn btn-primary">YES</a>
                    <span style="margin-right:100px;">&nbsp;</span>
                    <a href="{{ url("/feedback/rejected/{$message->id}") }}" class="btn btn-default">NO</a>
                </p>

                <br/>

                <span><label><input type="checkbox" name="agree" value="1" checked/> Agree to be contacted/ <a href="#" id="tos" style="color: blue">TOS</a></label></span>

                <br/><br/>
            </header>
        </section>
    </div>

    <div class="modal fade" id="tosModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $account->company_name }} TERMS OF SERVICES</h4>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h2>ACCEPTANCE</h2>
                        <p>When you sign-in with us, you are giving <strong>{{ $account->company_name }}</strong> your permission and consent to send you email and/or SMS text messages. By checking the Terms and Conditions box and by signing in you automatically confirm that you accept all terms in this agreement.</p>

                        <h2>SERVICE</h2>
                        <p>This is a free service provided by us to our VIP clients of which you are included. We provide a service that currently allows you to receive requests for feedback, company information, promotional information, company alerts, coupons, discounts and other notifications to your email address and/or cellular phone or device. Email delivery is free of any charges. SMS will be subject to your regular SMS rates, most carriers now have free inbound SMS messages associated with the display or delivery of each SMS text message sent to you by us.</p>

                        <h2>YOUR REGISTRATION DATA</h2>
                        <p>You agree to provide true, accurate, current and complete information about yourself as prompted by the Service's registration form (such information being the "Registration Data").</p>

                        <h2>PRIVACY</h2>
                        <p>The information provided during this registration is kept private and confidential, and will never be distributed, copied, sold, traded or posted in any way, shape or form. This is our guarantee.</p>

                        <h2>DISCLAIMER OF WARRANTIES</h2>
                        <p>You expressly understand and agree that: No advice or information, whether oral or written, obtained by you from <strong>{{ $account->company_name }}</strong> or through or from the service shall create any warranty not expressly stated in the TOS.</p>

                        <h2>OPT-OUT</h2>
                        <p>You may at any time opt out of notices from <strong>{{ $account->company_name }}</strong> by the following two options:</p>
                        <ol>
                            <li>Email us at <strong>({{ $account->contact_email }})</strong> with “Unsubscribe” in the subject line.</li>
                            <li>Text “Stop” to any message from us.</li>
                        </ol>

                        <p>By registering and subscribing to our email and SMS service, by opt-in, online registration or by filling out a card, "you agree to these TERMS OF SERVICE" and you acknowledge and understand the above Terms of Service outlined and detailed for you today.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" role="button" class="btn btn-default" data-dismiss="modal" id="btn-decline" onclick="$('input:checkbox').removeAttr('checked')">Decline</a>
                    <a href="#" role="button" class="btn btn-primary" data-dismiss="modal" id="btn-agree" onclick="$('input:checkbox').prop('checked', true)">Agree</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('on-page-js')

    @parent

    <!-- Scripts -->
    <script>
        $(document).ready(function(){
            $('#tos').on('click', function(e){
                $('#tosModal').modal();
            });
        });
    </script>

@endsection