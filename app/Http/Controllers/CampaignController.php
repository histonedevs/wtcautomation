<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Product;
use App\Account;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Datatables;
use yajra\Datatables\Html\Builder;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Debug\Dumper;
class CampaignController extends Controller
{
    private $line_number = 0;

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(Request $request, Builder $htmlBuilder, $user_id = Null){
        $columns = [
            make_column('campaign_name', 'campaigns.name', 'Campaign Name', 'text'),
            make_column('product_title', 'products.title', 'Product Name' , 'text'),
            make_column('asin' , 'products.asin', 'ASIN', 'text'),
            make_column('campaign_code', 'campaigns.couponCode', 'Coupon Code', 'text'),
            make_column('sms', null, '', null, [], '<a class="btn btn-primary sendSmsBtn" href="#" campaign_id="{{$id}}">Send SMS</a>', null, '0px', null, false),
        ];

        if(Auth::user()->user_type == 'admin' OR Auth::user()->user_type == 'supervisor'){
            $columns[] = make_column('download_discounted', null, '', null, [], '<a discount="1" class="btn btn-primary downloadOrdersBtn" href="#" campaign_id="{{$id}}">Promo</a>', null, '0px', null, false);
            $columns[] = make_column('download_non_discounted', null, '', null, [], '<a discount="0" class="btn btn-primary downloadOrdersBtn" href="#" campaign_id="{{$id}}">Standard</a>', null, '0px', null, false);
            $columns[] = make_column('edit_campaign', null, '', null, [], '<a class="btn btn-primary btn_edit_campaign" href="#" campaign_id="{{$id}}">Edit Campaign</a>', null, '0px', null, false);
        }

        $base_query = DB::table('campaigns')->select(
            ['campaigns.name as campaign_name', 'campaigns.id', 'campaigns.couponCode as campaign_code', 'products.title as product_title', 'products.asin']
        )->join('products', 'campaigns.product_id' , '=' , 'products.id')
            ->join('accounts', 'campaigns.user_id' , '=' , 'accounts.id')
        ->whereNull('accounts.deleted_at');

        if($user_id){
            $base_query->where(function($query) use($user_id){
                    $query->where('campaigns.user_id',$user_id)
                        ->orWhere('accounts.parent_id',$user_id);
                });

        }

        if($this->isAjax($request)){
            return $this->dataTable($columns, $request , Datatables::of($base_query))->make(true);
        }else{
            $data_table = build_data_table($htmlBuilder , $columns , $base_query , url('campaigns/index/'.$user_id));
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

                if($record->active) {
                    return '<a class="btn btn-primary createCampBtn" href="#" product_id="'.$record->id.'">Create New</a>';
                }

                return '';
            })
        ];

        $base_query = DB::table('products')->select(
            ['campaigns.name as campaign_name', 'products.id','products.active', 'products.title as product_title', 'products.asin', 'accounts.company_name']
        )->leftJoin('campaigns', 'campaigns.product_id' , '=' , 'products.id')
        ->join('accounts', 'products.user_id' , '=', 'accounts.id')
            ->whereNull('accounts.deleted_at');

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

    private function showImportError($error){
        p("Line # {$this->line_number} : {$error}");
    }

    /**
     * @param Request $request
     */
    public function postImportCsv(Request $request){
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $file_extension = strtolower($file->getClientOriginalExtension());

            if ($file_extension == 'csv') {
                if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
                    fgetcsv($handle, 1000);

                    $account = NULL;
                    while (($row = fgetcsv($handle, 1000)) !== FALSE) {
                        $this->line_number ++;

                        if(!empty($row[0])){
                            $account = Account::where('email', $row[3])
                                ->whereParentId(null)->first();

                            if($account) {
                                if(!$account->logo && !empty($row[6])) {
                                    $account->logo = $row[6];
                                }

                                $account->website = $row[2];
                                $account->contact_person = $row[1];
                                $account->company_name = $row[0];
                                $account->save();

                                foreach($account->children as $child){
                                    $child->logo = $account->logo;
                                    $child->website = $row[2];
                                    $child->contact_person = $row[1];
                                    $child->company_name = $row[0];
                                    $child->save();
                                }
                            }else{
                                $this->showImportError("Account with email {$row[3]} not found");
                            }
                        }

                        if($account && !empty($row[9])){
                            $this->saveCampaign($row, $account);
                        }else{
                            $this->showImportError("Skipping, because account/asin was not found");
                        }
                    }
                    fclose($handle);
                }
            }
        }

        print "<a href=''>Go back</a>";
    }

    private function saveCampaign($row, $account){
        $products = Product::where('asin', $row[9])->get();
        $chosen_product = null;
        if(count($products) == 1){
            $chosen_product = $products[0];
        }else{
            foreach($products as $product){
                if($product->user_id == $account->id){
                    $chosen_product = $product;
                }

                foreach($account->children as $child){
                    if($product->user_id == $child->id){
                        $chosen_product = $product;
                        break;
                    }
                }

                if($chosen_product){
                    break;
                }
            }
        }

        if($chosen_product){
            $this->showImportError("Found Product {$chosen_product->id}");

            if(!$chosen_product->campaign){
                Campaign::create([
                    'user_id' => $chosen_product->user_id,
                    'product_id' => $chosen_product->id,
                    'name' => $row[7],
                ]);
                $this->showImportError("Created Campaign");
            }else{
                $this->showImportError('A Camp already exists, I will not create');
            }
        }else{
            $this->showImportError("No product found with asin: {$row[9]}");
        }
    }

    public function postEdit(Request $request){
        $campaign = Campaign::find($request->get('campaign_id'));
        $campaign->name = $request->get('camp_name');
        $campaign->couponCode = $request->get('camp_code');
        $campaign->save();
        return 'ok';
    }
}
