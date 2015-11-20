@extends('layout.master')

@section('content')

    <form role="form" method="POST" action="{{ url('auth/login') }}">
        {!! csrf_field() !!}
        <table>
            <tbody>
            <tr>
                <td>Email</td><td><input type="email" name="email" id="email"></td>
            </tr>
            <tr>
                <td>Password</td><td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Login"></td>
            </tr>
            </tbody>
        </table>

    </form>
@stop



@stop