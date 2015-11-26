<?php

namespace App\Http\Controllers;

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
    public function getIndex(FormBuilder $formBuilder)
    {
        $form = $this->form($formBuilder);
        return view('users.orders', ['form' => $form]);
    }

    public function postDownload(Request $request, FormBuilder $formBuilder)
    {
        $user = $request->get('users');
        $child_user = $request->get('child_users');
        $product = $request->get('products');
        $fromDate = Carbon::parse($request->get('fromDate'));
        $toDate = Carbon::parse($request->get('toDate'));

        $results = DB::table('sale_order_items as soi')
            ->select([
                'so.amazon_order_id', 'p.asin', 'soi.item_price as price', 'soi.quantity_ordered as quantity',
                'so.purchased_at', 'so.order_status', 'b.name as buyer_name'
            ])
            ->join('sale_orders as so', 'soi.sale_order_id', '=', 'so.id')
            ->leftJoin('buyers as b', 'b.id', '=', 'so.buyer_id')
            ->join('products as p', 'soi.product_id', '=', 'p.id')
            ->where('so.user_id', $user)
//            ->where('soi.product_id', $product)
            ->where('so.created_at', '>=', $fromDate)
            ->where('so.updated_at', '<=', $toDate)
            ->get();

        if ($results) {

            $filename = tempnam('', '') . ".csv";
            $heading = array('Amazon Order', 'ASIN', 'Price', 'Quantity', 'Order Date', 'Order Status', 'Buyer Name');
            $fp = fopen($filename, 'w');
            fputcsv($fp, $heading);
            foreach ($results as $result) {
                fputcsv($fp, (Array)$result);
            }
            fclose($fp);
        }

        return response()->download($filename);
    }

    public function form($formBuilder)
    {
        $users = Account::whereParentId(NULL)->get();
        $options = array();
        foreach ($users as $user) {
            $options[$user->id] = $user->name;
        }

        $form = $formBuilder->create('App\Forms\UserOrderForm',
            [
                'method' => 'POST',
                'url' => url("download/download"),
                'class' => 'form-horizontal',
                'role' => 'form'
            ], [
                'options' => $options
            ]
        );

        return $form;
    }

    public function getChildUser()
    {
        $user = Input::get('user');
        $userParent = Account::find($user);
        $child_users = DB::table('accounts')
            ->select('id', 'name')
            ->where('parent_id', $user)
            ->get();

        return view('users.select_childs', compact('child_users', 'userParent'));
    }

    public function getProduct()
    {
        $child_user = Input::get('child_user');
        $products = DB::table('products')
            ->select('id', 'title')
            ->where('user_id', $child_user)
            ->get();

        return view('users.select_products', compact('products'));
    }
}
