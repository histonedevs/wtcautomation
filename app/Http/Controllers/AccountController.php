<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(){
        return view('accounts.index', []);
    }

    public function getCsv(){
        return view('accounts.csv', []);
    }

    public function postCSV(Request $request){
        //save
    }

    public function getEdit($account_id){
        return view('accounts.form', []);
    }
}
