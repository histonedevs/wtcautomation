@extends('layout.master')

@section('content')
   {{-- COMING SOON--}}
   <h3>Accounts</h3>
   {!! $data_table->table(['class' => 'table table-striped table-hover', 'id' => 'table_accounts']) !!}

@endsection

@section('page-script')
    {!! makeScripts($data_table) !!}

    <script>
        $(document).on('click','.delete_account',function(e){
            e.preventDefault();
            var path = $(this).attr('path');
            var r = confirm("Are you sure to Delete the account?");
            if (r == true) {
                $.ajax({
                    url: path,
                    type: "get",
                    success: function (data) {
                        location.reload();
                    }
                });
            } else {
                console.log('not deleted account');
            }

        });
    </script>
@endsection