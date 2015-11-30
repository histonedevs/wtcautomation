<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Account;
use DB;
use App\UserCompany;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex()
    {
       /* $users=array();
        $parent_users = Account::whereParentId(NULL)->get();
        foreach ($parent_users as $parent_user) {
            $users[$parent_user->id]['parent'] = $parent_user;
            $child_users = DB::table('accounts')
                ->select('*')
                ->where('parent_id', $parent_user->id)
                ->get();

             $users[$parent_user->id]['children']=$child_users;
        }*/
        $parent_users = Account::whereParentId(NULL)->get();
        return view('accounts.index', compact('parent_users'));
    }

    public function getCsv()
    {
        return view('accounts.csv', []);
    }

    public function postCSV(Request $request)
    {
        //save
    }

    public function getEdit(Request $request,$account_id)
    {

        return view('accounts.form',compact('account_id'));
    }

    public function postEdit(Request $request,$account_id){

         $this->validate($request, [
            'company_name' => 'required',
            'logo' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move("uploads", $filename);
            $request['logo'] = $filename;
        }
//          $company=UserCompany::find(1);
//          UserCompany::updateOrCreate($request);
    }
}
