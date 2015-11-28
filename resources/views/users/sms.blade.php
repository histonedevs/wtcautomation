@extends('layout.master')

@section('content')
    @if($errors)
        @foreach($errors->all() as $error)
           <div class="alert alert-danger">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ $error }}
           </div>
        @endforeach
    @endif


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form role="form" method="POST" action="{{ url('users/sms') }}" >
                {!! csrf_field() !!}
                <h3>Send SMS</h3>
                <div class="form-group">
                    <label for="users" class="control-label">Users</label>
                    <select class="form-control"  id="users" name="users">
                        <option>Select Users</option>
                        @foreach($users as $user)
                            <option value='{{$user->id}}' > {{$user->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact No." >
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Send</button>
            </form>
        </div>
    </div>
@section('page-script')

    {!! Html::script('assets/js/common.js') !!}

@endsection
@endsection





