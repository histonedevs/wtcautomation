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
                <div class="form-group">
                    <label for="email">User Type</label>
                    <select name="user_type" id="user_type" class="form-control">
                        <option value="">Choose a user type</option>
                        <option value="admin">Admin</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="operator">Operator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $("#user_type").val('{{$user->user_type}}');
    </script>
@endsection