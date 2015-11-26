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

            $(document).on('change','#users',function(e){
                var user = $('#users').val();
                $.ajax({
                    url: "download/child-user",
                    type: "get",
                    data: {'user': user},
                    success: function (data) {
                        $(".div_child_users").remove();
                        var closest_form_group = $('#users').closest('div[class^="form-group"]');
                        if(user=="") {
                            $(".div_child_users").remove();
                        }
                        else {
                            $(data).insertAfter(closest_form_group);
                        }
                    }
                });
            });

            $(document).on('change','#child_users',function(e){
                var child_user = $('#child_users').val();
                $.ajax({
                    url: "download/product",
                    type: "get",
                    data: {'child_user': child_user},
                    success: function (data) {
                        console.log(data);
                        $(".div_products").remove();
                        var closest_form_group = $('#child_users').closest('div[class^="form-group"]');
                        $(data).insertAfter(closest_form_group);
                    }
                });
            });
        });
    </script>
@stop