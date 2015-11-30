<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use yajra\Datatables\Html\Builder;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(Request $request, Builder $htmlBuilder){
        $columns = [
            make_column('campaign_name', 'campaigns.name', 'Campaign Name', 'text'),
            make_column('product_title', 'products.title', 'Product Name' , 'text'),
            make_column('asin' , 'products.asin', 'ASIN', 'text'),
            make_column('sms', null, '', null, [], '<a class="btn btn-primary sendSmsBtn" href="#" campaign_id="{{$id}}">Send SMS</a>', null, '0px', null, false),
            make_column('download', null, '', null, [], '<a class="btn btn-primary downloadOrdersBtn" href="#" campaign_id="{{$id}}">Download</a>', null, '0px', null, false)
        ];

        $base_query = DB::table('campaigns')->select(
            ['campaigns.name as campaign_name', 'campaigns.id', 'products.title as product_title', 'products.asin']
        )->join('products', 'campaigns.product_id' , '=' , 'products.id');

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('campaigns'));
            return view('campaigns.index', compact('data_table'));
        }
    }

    public function getAdd(){
        return view('campaigns.form', []);
    }

    public function getEdit($campaign_id){
        return view('campaigns.form', []);
    }
}
