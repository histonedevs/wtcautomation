@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {!! form($form) !!}
        </div>
    </div>

@endsection
@section('page-script')
    <script>
        $(document).ready(function () {
            $("#fromDate").datepicker();
            $("#toDate").datepicker();
            });
    </script>
    {!! Html::script('assets/js/common.js') !!}
@stop