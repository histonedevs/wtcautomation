<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Account;
use DB;
use App\UserCompany;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class AccountController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex()
    {
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

    public function getEdit(Request $request, $account_id)
    {
        $account = Account::find($account_id);
        $form = $this->form('App\Forms\EditAccountForm', ['model' => $account]);
        return view('accounts.form', compact('account_id', 'form'));
    }

    public function postEdit(Request $request, $account_id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'logo' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move("uploads", $filename);
            $request['logo'] = $filename;
        }
    }
}
