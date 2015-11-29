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
        return view('accounts.form', []);
    }

    public function getEdit($campaign_id){
        return view('accounts.form', []);
    }
}
