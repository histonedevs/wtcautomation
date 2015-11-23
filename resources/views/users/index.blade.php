@extends('layout.master')
@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{!! HTML::image('/uploads/'.$employee->image, 'alt',['class'=>'img-thumbnail']) !!}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->address }}</td>
                <td>
                    {!! Html::linkRoute('admin.employees.edit', 'Edit', [$employee->id],['class' => 'btn btn-primary']) !!}
                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.employees.destroy', $employee->id],'class'=>'delete-form']) !!}
                    {!! Form::submit('Delete',['class'=> 'btn btn-danger btn-delete']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop