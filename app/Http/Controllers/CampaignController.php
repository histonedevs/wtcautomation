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
            make_column('campaign_name', 'campaigns.name as campaign_name', 'Campaign Name', 'text'),
        ];

        $base_query = DB::table('campaigns')->select(['campaigns.name as campaign_name']);

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
