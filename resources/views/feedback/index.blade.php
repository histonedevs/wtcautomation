@extends('layout.master')

@section('content')
    {!! $data_table->table(['class' => 'table table-striped table-hover', 'id' => 'table_campaigns']) !!}
@endsection

@section('page-script')
    {!! makeScripts($data_table) !!}
@endsection

