@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form role="form" method="POST" action="{{ url('users/add') }}" >
                {!! csrf_field() !!}
                <h3>Register User</h3>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
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
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Save</button>

            </form>
        </div>
    </div>
@endsection




