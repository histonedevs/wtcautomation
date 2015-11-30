<?php

namespace App\Http\Controllers;

use App\Account;
use App\Product;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Datatables;
use yajra\Datatables\Html\Builder;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
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

    public function getImportCsv(){
        return view('campaigns.import');
    }

    public function postImportCsv(Request $request)
    {
        if (Input::hasFile('csv_file')) {
            $file = Input::file('csv_file');
            $file_extension = $file->getClientOriginalExtension();
            if ($file_extension == 'csv') {
                $file = Input::file('csv_file');
                $row = 0;
                if (($handle = fopen($file, "r")) !== FALSE) {
                    $account_ = null;
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $row++;
                        if ($row > 1) {
                            if($row[0]==""){
                                /*$product = Product::where('asin',$row[9])->get();
                                if(count($product) == 1){
                                    $product->title = $row[0];
                                    $product->image_url = $row[6];

                                use account ---- $account_
                                }*/

                            }else{
                                $account = Account::where('email', $row[3])->first();
                                if(count($account)){
                                    $account_ = $account;
                                    $product = Product::where('asin',$row[9])->get();
                                    if(count($product) == 1){
                                        $product = Product::where('asin',$row[9])->first();
                                        $product->title = $row[0];
                                        $product->image_url = $row[6];
                                        $product->save();
                                    }else{
                                        $child_ids = Account::where('parent_id',$account->id)->get();

                                        $product =DB::table('accounts')
                                                        ->where('user_id', $account->id)
                                                        ->orWhereIn('user_id',$child_ids)
                                                        ->first();

                                        $product->title = $row[0];
                                        $product->image_url = $row[6];
                                        $product->save();

                                    }
                                }
                            }
                        }
                    }
                    fclose($handle);
                }
            }
        }
    }

}
