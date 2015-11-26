@extends('layout.master')

@section('content')
    @if($errors)
        @foreach($errors as $error)

        @endforeach
    @endif


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form role="form" method="POST" action="{{ url('users/sms') }}" >
                {!! csrf_field() !!}
                <h3>Send SMS</h3>
                <div class="form-group">
                    <label for="asin">ASIN</label>
                    <input type="text" class="form-control" id="asin" name="asin" placeholder="Enter ASIN" >
                </div>
                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact No." >
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Send</button>

            </form>
        </div>
    </div>
@endsection




