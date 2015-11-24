@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form role="form" method="POST" action="{{ url('users/edit/'.$user->id) }}" >
                {!! csrf_field() !!}
                <h3>Update User</h3>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{$user->name}}" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required="required">
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Update</button>
            </form>
        </div>
    </div>
@endsection
