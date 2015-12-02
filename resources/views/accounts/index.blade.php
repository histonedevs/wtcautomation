@extends('layout.master')

@section('content')
   {{-- COMING SOON--}}
   <h3>Accounts</h3>
   {!! $data_table->table(['class' => 'table table-striped table-hover', 'id' => 'table_accounts']) !!}

@endsection

@section('page-script')
    {!! makeScripts($data_table) !!}
@endsection