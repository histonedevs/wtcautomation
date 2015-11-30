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
    public function getIndex(){
        return redirect('campaigns');
    }
}
