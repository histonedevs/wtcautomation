<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Product;
use App\Account;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
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

    public function getAdd(Request $request, Builder $htmlBuilder){
        $columns = [
            make_column('asin' , 'products.asin', 'ASIN', 'text'),
            make_column('product_title', 'products.title', 'Product Name' , 'text'),
            make_column('company_name', 'accounts.company_name', 'Company', 'text'),
            make_column('campaign_name', 'campaigns.name', 'Campaign Name', 'text', [], function($record){
                if($record->campaign_name) {
                    return $record->campaign_name;
                }
                return '<a class="btn btn-primary createCampBtn" href="#" product_id="'.$record->id.'">Create New</a>';
            })
        ];

        $base_query = DB::table('products')->select(
            ['campaigns.name as campaign_name', 'products.id', 'products.title as product_title', 'products.asin', 'accounts.company_name']
        )->leftJoin('campaigns', 'campaigns.product_id' , '=' , 'products.id')
        ->join('accounts', 'products.user_id' , '=', 'accounts.id')
        ;

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('campaigns/add'));
            return view('campaigns.add', compact('data_table'));
        }
    }

    public function postAdd(Request $request){
        $this->validate($request, [
            'product_id' => 'required',
            'campName' => 'required',
        ]);

        $product = Product::find($request->get('product_id'));
        if(!$product) return "Product not found";

        if($product->campaign) return "Product has already a campaign";

        Campaign::create([
            "name" => $request->get('campName'),
            'user_id' => $product->user_id,
            'product_id' => $product->id
        ]);

        return "ok";
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
                    $account_ = NULL;
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $row++;
                        if ($row > 1) {
                            if($row[0] == ""){
                                //add_campaign($row[9], $account_->id);
                                $product = Product::where('asin',$row[9])->get();
                                if(count($product) == 1){

                                    $campaign = [
                                        'user_id' => $account_->id,
                                        'product_id' => $product[0]->id

                                    ];

                                    Campaign::create($campaign);

                                }else{
                                    // logic for campaigns
                                    // if product found for more than one account
                                    // starts here
                                }
                            }else{
                                $account = Account::where('email', $row[3])->first();
                                if(count($account)) {
                                    echo $row[3];
                                    $account_ = $account;
                                    $account->logo = $row[6];
                                    $account->website = $row[2];
                                    $account->contact_person = $row[1];
                                    $account->company_name = $row[0];
                                    $account->save();

                                }

                                $product = Product::where('asin',$row[9])->get();
                                if(count($product) == 1){

                                    $campaign = [
                                        'user_id' => $account_->id,
                                        'product_id' => $product[0]->id

                                    ];

                                    Campaign::create($campaign);

                                }else{
                                    // logic for campaigns
                                    // if product found for more than one account
                                    // starts here
                                }
                                //$this->add_campaign($row[9], $account_->id);
                            }
                        }
                    }
                    fclose($handle);
                }
            }
        }
    }

    public  function add_campaign($asin,$account_id){
        $product = Product::where('asin', $asin)->get();
        if(count($product) == 1){

            $campaign = [
                'user_id' => $account_id,
                'product_id' => $product[0]->id

            ];

            Campaign::create($campaign);

        }else{
            // logic for campaigns
            // if product found for more than one account
            // starts here
        }
    }

}
