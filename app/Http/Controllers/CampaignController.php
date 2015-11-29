<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(){
        return view('campaigns.index', []);
    }

    public function getAdd(){
        return view('campaigns.form', []);
    }

    public function getEdit($campaign_id){
        return view('campaigns.form', []);
    }
}
