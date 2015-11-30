@extends('layout.master')

@section('content')
   {{-- COMING SOON--}}
   <h3>Accounts</h3>
   <table class="table table-bordered">
       <thead>
       <tr>
           <th>Parent</th>
           <th>First Name</th>
           <th>Last Name</th>
           <th>Email</th>
           <th>Actions</th>
       </tr>
       </thead>
       <tbody>
       @foreach($parent_users as $parent_user)
           <tr>
               <td></td>
               <td>{{ $parent_user->first_name }}</td>
               <td>{{ $parent_user->last_name }}</td>
               <td>{{ $parent_user->email }}</td>
               <td>
                   <a href="{{url('accounts/edit/1')}}" class="btn btn-warning">Edit</a>
               </td>

           </tr>
       @endforeach
       </tbody>
   </table>

@endsection