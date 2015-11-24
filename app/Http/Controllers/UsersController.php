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
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function postAdd(Request $request)
    {
        $user = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        );

        User::create($user);
        return redirect('users/index');
    }

    public function getAdd()
    {
        return view('users.add_user');
    }

    public function getDelete($id)
    {
        User::find($id)->delete();
        return redirect('users/index');
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        return view('users.edit_user', compact('user'));
    }

    public function postEdit(Request $request, $id)
    {
        $request = array(
            'name' => $request->get('name'),
            'email' => $request->get('email')
        );
        $user = User::find($id);
        $user->update($request);
        return redirect('users/index');
    }

}
