<?php

namespace App\Http\Controllers;

use App\Variable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\UserCompany;
use Illuminate\Support\Facades\Session;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Datatables;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Company;
use App\Account;
class SettingsController extends Controller
{
    use FormBuilderTrait;
    public function __construct()
    {
        $this->middleware("auth");
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCampaignSmsText(FormBuilder $formBuilder)
    {
        $sms_text = Variable::where('name','campaign_sms_text')->first();
        $form = $formBuilder->create('App\Forms\SmsTextUpdate', [
            'method' => 'POST',
            'class' => 'form-horizontal',
            'role' => "form"

        ], array('text' => $sms_text->value));
        return view("settings.campaign_sms_text", compact('form'));


    }

    public function postCampaignSmsText(Request $request)
    {
       $variable = Variable::where('name','campaign_sms_text')->first();
        $form = $this->form('App\Forms\SmsTextUpdate', ['method' => 'POST']);

        if($form->isValid()){
            $variable->value = $request->get('value');
            $variable->save();

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
