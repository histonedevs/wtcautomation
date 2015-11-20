<?php

namespace App\Http\Controllers\Home;

use App\SaleOrder;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Account;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Maatwebsite\Excel\Facades\Excel;
use App;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(FormBuilder $formBuilder)
    {
        $form = $this->form($formBuilder);
        return view('users.orders',['form'=>$form]);
    }

    public function postDownload(Request $request,FormBuilder $formBuilder)
    {
        $user = $request->get('users');
        $fromDate= Carbon::parse($request->get('fromDate'));
        $toDate= Carbon::parse($request->get('toDate'));

        $results = DB::table('sale_orders')
            ->where('user_id',$user )
            ->where('created_at','>=', $fromDate)
            ->where('updated_at', '<=', $toDate)
            ->get();

        $filename = tempnam('', '').".csv";

        $fp = fopen($filename, 'w');
        foreach ($results as $result) {
            fputcsv($fp, (Array)$result);
        }
        fclose($fp);

        return response()->download($filename);
    }

    public function form( $formBuilder) {

        $users=Account::all();
        $options = array();
        foreach($users as $user){
            $options[$user->id] = $user->name;
        }

        $form = $formBuilder->create('App\Forms\UserOrderForm',
            [
                'method' => 'POST',
                'url' => url("home/download"),
                'class' => 'form-horizontal',
                'role' => 'form'
            ],[
                'options'=>$options
            ]
        );

        return $form;

    }
}
