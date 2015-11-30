@extends('layout.master')

@section('content')
    <form id="frm_import_csv" method="post" role="form" enctype="multipart/form-data" action="{{url('campaigns/import-csv')}}">
        {!! csrf_field() !!}
        <input type="hidden" name="pid">
        <div class="form-group">
            <label for="csv_file">select a Csv file to import campaigns</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="frm_submit" id="frm_submit" value="Import" >
        </div>
    </form>
@endsection