@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form role="form" method="POST" action="{{ url('accounts/edit/'.$account_id) }}" enctype="multipart/form-data" >
                {!! csrf_field() !!}
                <h3>Update</h3>
                <div class="form-group">
                    <label for="Company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="" required="required">
                </div>
                <div class="form-group">
                    <label for="file">Upload Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo" value="" required="required">
                </div>
                <button type="submit" class="btn btn-default" id="submit" name="submit">Update</button>
            </form>
        </div>
    </div>
@endsection