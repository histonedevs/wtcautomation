<?php

namespace App\Http\Controllers;

use App\Api\GoogleUrl;
use App\Api\Twilio;
use App\Api\UrlShortenerApi;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use \Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Services_Twilio;
use Services_Twilio_TinyHttp;
use Illuminate\Support\Facades\Session;
use \Validator;
use App\Account;
use Datatables;
use yajra\Datatables\Html\Builder;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }


    /**
     * @param Request $request
     * @param Builder $htmlBuilder
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request, Builder $htmlBuilder)
    {
        $columns = [
            make_column('name' , 'users.name', 'Name', 'text'),
            make_column('email' , 'users.email', 'Email', 'text'),
            make_column('sms', null, '', null, [], '<a class="btn btn-warning" href="{{url("users/edit/".$id)}}">Edit</a>', null, '0px', null, false),
            make_column('download', null, '', null, [], '<a class="btn btn-danger" href="{{url("users/delete/".$id)}}">Delete</a>', null, '0px', null, false)

        ];

        $base_query = DB::table('users')
            ->select('users.*');

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('users'));
            return view('users.index', compact('data_table'));
        }/*
        $users = User::all();
        return view('users.index', compact('users'));*/
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

    public function getDelete($id){
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

    public function getChildUser()
    {
        $user = Input::get('user');
        $userParent = Account::find($user);
        $child_users = DB::table('accounts')
            ->select('id', 'name', 'account_title')
            ->where('parent_id', $user)
            ->get();

        return view('users.select_childs', compact('child_users', 'userParent'));
    }

    public function getProduct()
    {
        $child_user = Input::get('child_user');
        $products = DB::table('products')
            ->select('id', 'title', 'asin')
            ->where('user_id', $child_user)
            ->get();

        return view('users.select_products', compact('products'));
    }
}
