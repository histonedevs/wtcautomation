@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {!! form($form) !!}
        </div>
        <div class="col-md-8 col-md-offset-2">
            <p> Use [COMPANY_NAME] and [URL] placeholders: </p>
        </div>
    </div>
@endsection