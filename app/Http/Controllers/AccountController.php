<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Account;
use DB;
use App\UserCompany;
use Illuminate\Support\Facades\Session;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Datatables;
use yajra\Datatables\Html\Builder;

class AccountController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(Request $request, Builder $htmlBuilder)
    {
        $columns = [
            make_column('logo', null, 'Logo', null, [],
                function($record){
                    if($record->logo){
                        return "<img style='max-width: 200px' src='{$record->logo}' />";
                    }else{
                        return "";
                    }
                } , null, '0px', null, false),
            make_column('company_name', 'accounts.company_name', 'Company Name' , 'text'),
            make_column('name' , 'accounts.name', 'Name', 'text'),
            make_column('contact_email' , 'accounts.contact_email', 'Contact Email', 'text'),
            make_column('edit', null, '', null, [], '<a class="btn btn-primary" href="{{url("accounts/edit/".$id)}}">Edit</a>', null, '0px', null, false),
            make_column('campaign', null, '', null, [], '<a class="btn btn-primary" href="{{url("campaigns/index/".$id)}}">Campaigns</a>', null, '0px', null, false),
            make_column('delete', null, '', null, [], '<a class="btn btn-danger delete_account" href="#" path="{{url("accounts/delete/".$id)}}">Delete</a>', null, '0px', null, false),
        ];

        $base_query = DB::table('accounts')
                        ->whereParentId(NULL)
                        ->whereDeletedAt(NULL)
                        ->select('accounts.*');

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('accounts'));
            return view('accounts.index', compact('data_table'));
        }
    }

    public function getCsv()
    {
        return view('accounts.csv', []);
    }

    public function postCSV(Request $request)
    {
        //save
    }

    public function getEdit($account_id)
    {
        $account = Account::find($account_id);
        $form = $this->form('App\Forms\EditAccountForm', ['model' => $account, 'method' => 'POST']);
        return view('accounts.form', compact('account_id', 'form'));
    }

    public function postEdit(Request $request, $account_id)
    {
        $account = Account::find($account_id);
        $form = $this->form('App\Forms\EditAccountForm', ['model' => $account, 'method' => 'POST']);

        if($form->isValid()){
            $account->company_name = $request->company_name;
            $account->contact_person = $request->contact_person;
            $account->website = $request->website;
            $account->contact_email = $request->contact_email;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = $account_id . '.' . $file->getClientOriginalExtension();
                $file->move("uploads/logos/", $filename);
                $account->logo = asset('uploads/logos/'.$filename);
            }

            $account->save();

            foreach($account->children as $child){
                $child->company_name = $account->company_name;
                $child->contact_person = $account->contact_person;
                $child->website = $account->website;
                $child->contact_email = $account->contact_email;
                $child->logo = $account->logo;
                $child->save();
            }

            Session::flash('success' , "Saved");
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
    }

    public function getDelete($user_id)
    {
        $user = Account::find($user_id);
        $user->delete();
        return redirect(url("accounts"));
    }
}
