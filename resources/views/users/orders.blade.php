@extends('layout.master')

@section('content')

    {!! form($form) !!}
@endsection
@if(isset($result))
@section('show')
<table border="1" width="100%" cellpadding="5">
    <thead>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Buyer</th>
        <th>Amazon</th>
        <th>Order Status</th>
        <th>Fulfillment Channel</th>
        <th>Sales Channel</th>
        <th>Carrier</th>
        <th>Tracking Number</th>

    </tr>
    </thead>
    <tbody>
    @foreach($result as $res)
    <tr>
        <td>{{ $res->unique_id  }}</td>
        <td>{{ $res->user_id  }}</td>
        <td>{{ $res->buyer_id  }}</td>
        <td>{{ $res->amazon_order_id  }}</td>
        <td>{{ $res->order_status  }}</td>
        <td>{{ $res->fulfillment_channel  }}</td>
        <td>{{ $res->sales_channel  }}</td>
        <td>{{ $res->carrier }}</td>
        <td>{{ $res->tracking_number  }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
@endif
@section('page-script')
    <script>
      $(document).ready(function(){
          $( "#fromDate" ).datepicker();
          $("#toDate").datepicker();

      })
    </script>
@stop