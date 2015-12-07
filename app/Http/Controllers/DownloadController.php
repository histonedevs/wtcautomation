<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\SaleOrder;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Account;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use App;
use \Input;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function getIndex(Request $request)
    {
        $this->validate($request, [
            'campaign_id' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required'
        ]);

        try {
            $fromDate = Carbon::parse($request->get('dateFrom'));
            $toDate = Carbon::parse($request->get('dateTo'));
        }catch (\Exception $ex){
            return $ex->getMessage();
        }

        $campaign = Campaign::find($request->campaign_id);

        $results = DB::table('sale_order_items as soi')
            ->select([
                'b.orders_count', 'b.first_name', 'b.last_name', 'b.address1', 'b.city', 'b.state', 'b.zip', 'l.country', 'b.phone', 'b.email', 'so.amazon_order_id', 'so.purchased_at', 'p.title', 'soi.item_price as price', 'p.asin'
            ])
            ->join('sale_orders as so', 'soi.sale_order_id', '=', 'so.id')
            ->leftJoin('buyers as b', 'b.id', '=', 'so.buyer_id')
            ->leftJoin('locations as l', 'l.id', '=', 'b.location_id')
            ->join('products as p', 'soi.product_id', '=', 'p.id')
            ->where('soi.product_id', $campaign->product_id)
            ->where('so.purchased_at', '>=', $fromDate)
            ->where('so.purchased_at', '<=', $toDate)
            ->where('so.order_status','Shipped')
            ->where('b.phone', '!=' , '')
            ->whereNotNull('b.phone');

            if($request->discounted){
                $results->where('soi.item_discount', '>', 0);
            }else{
                $results->where(function($query){
                    $query->where('soi.item_discount', '=', 0)
                        ->orWhere('soi.item_discount', null);
                });
            }
        
        $results = $results->get();

        $filename = tempnam('', '') . ".csv";
        $heading = array('# of Orders', 'First Name', 'Last Name', 'Address', 'City', 'State', 'Postal Code', 'Country', 'Phone', 'Amazon Email', 'Amazon #', 'Sale Date', 'Product', 'Price', 'Asin');

        $fp = fopen($filename, 'w');
        fputcsv($fp, $heading);

        if ($results) {
            foreach ($results as $result) {
                fputcsv($fp, (Array)$result);
            }
        }

        fclose($fp);
        return response()->download($filename);
    }

    public function postIndex(Request $request, FormBuilder $formBuilder)
    {
        $user = $request->get('users');
        $child_user = $request->get('child_users');
        $product = $request->get('products');
        $fromDate = Carbon::parse($request->get('fromDate'))->startOfDay();
        $toDate = Carbon::parse($request->get('toDate'))->endOfDay();

        $results = DB::table('sale_order_items as soi')
            ->select([
                'b.orders_count', 'b.first_name', 'b.last_name', 'b.address1', 'b.city', 'b.state', 'b.zip', 'l.country', 'b.phone', 'b.email', 'so.amazon_order_id', 'so.purchased_at', 'p.title', 'soi.item_price as price', 'p.asin'
            ])
            ->join('sale_orders as so', 'soi.sale_order_id', '=', 'so.id')
            ->leftJoin('buyers as b', 'b.id', '=', 'so.buyer_id')
            ->leftJoin('locations as l', 'l.id', '=', 'b.location_id')
            ->join('products as p', 'soi.product_id', '=', 'p.id')
            ->where('so.user_id', $child_user)
            ->where('soi.product_id', $product)
            ->where('so.purchased_at', '>=', $fromDate)
            ->where('so.purchased_at', '<=', $toDate)
            ->get();

        $filename = tempnam('', '') . ".csv";
        $heading = array('# of Orders', 'First Name', 'Last Name', 'Address', 'City', 'State', 'Postal Code', 'Country', 'Phone', 'Amazon Email', 'Amazon #', 'Sale Date', 'Product', 'Price', 'Asin');
        $fp = fopen($filename, 'w');
        fputcsv($fp, $heading);

        if ($results) {
            foreach ($results as $result) {
                fputcsv($fp, (Array)$result);
            }
        }

        fclose($fp);
        return response()->download($filename);
    }
}
