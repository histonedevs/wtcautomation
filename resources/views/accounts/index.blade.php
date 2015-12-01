@extends('layout.master')

@section('content')
   {{-- COMING SOON--}}
   <h3>Accounts</h3>
   <table class="table table-bordered">
       <thead>
       <tr>
           <th>Logo</th>
           <th>Company</th>
           <th>Name</th>
           <th>Email</th>
           <th>Actions</th>
       </tr>
       </thead>
       <tbody>
       @foreach($parent_users as $parent_user)
           <tr>
               <td>
                   @if($parent_user->logo)
                       <img style="max-width: 200px" src="{{$parent_user->logo}}">
                   @endif
               </td>
               <td>{{ $parent_user->company_name }}</td>
               <td>{{ $parent_user->name }}</td>
               <td>{{ $parent_user->email }}</td>
               <td>
                   <a href="{{url("accounts/edit/{$parent_user->id}")}}" class="btn btn-warning">Edit</a>
               </td>

           </tr>
       @endforeach
       </tbody>
   </table>

@endsection