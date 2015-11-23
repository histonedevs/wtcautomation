<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
         return view('users.add_user');
    }

   public function postUser(Request $request)
   {
         $user = array(
             'name' => $request->get('name'),
             'email'=> $request->get('email'),
             'password' => Hash::make($request->get('password'))
         );

         User::create($user);


   }

}
