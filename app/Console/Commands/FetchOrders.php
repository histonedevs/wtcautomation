<?php

namespace App\Console\Commands;

use App\Account;
use App\Location;
use Illuminate\Console\Command;
use Curl\Curl;
use App\Buyer;
use App\SaleOrder;
use App\SaleOrderItem;
use App\Product;

class FetchOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:fetch_orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @param $url
     * @return string
     * @throws \Exception
     */
    private function callAPI($url){
        $curl = new Curl();
        $r = $curl->get(env("API_URL")."/api/{$url}",
            array(
                'email' =>  env('API_USERNAME'),
                'password' => env('API_PASSWORD')
            )
        );

        if(@isset($r->error)){
            throw new \Exception($r->error);
        }

        return $r;
    }


    /**
     * @param $user
     * @return string
     * @throws \Exception
     */
    private function getMoreOrders($user){
        $last_order_id = 0;

        $last_order = SaleOrder::where('user_id', $user->id)->orderBy('unique_id', 'DESC')->take(1)->first();
        if ($last_order) {
            $last_order_id = $last_order->unique_id;
        }

        return $this->callAPI("orders/list/{$user->unique_id}/{$last_order_id}");
    }

    /**
     * @throws \Exception
     */
    private function getUsers(){
        $r = $this->callAPI('users');
        foreach ($r as $record) {
            $account = $this->saveItem('App\Account',$record);
            foreach ($record->children as $row) {
                $row->parent_id = $account->id;
                $child = $this->saveItem('App\Account',$row);
            }
        }
    }

    /**
     *
     */
    private function getOrders(){
        $users = Account::all();

        foreach ($users as $user) {
            while (count($r = $this->getMoreOrders($user)) > 0) {
                foreach ($r as $record) {
                    $location = $this->saveItem('App\Location', $record->buyer->location);

                    $record->buyer->location_id = $location->id;
                    $buyer = $this->saveItem('App\Buyer' , $record->buyer);

                    $record->buyer_id = $buyer->id;
                    $record->user_id = Account::whereUniqueId($record->user_id)->first()->id;

                    $sale = $this->saveItem('App\SaleOrder' , $record);

                    foreach ($record->sale_order_items as $row) {
                        $row->product->user_id = $sale->user_id;
                        $product = $this->saveItem('App\Product' , $row->product);

                        $row->sale_order_id = $sale->id;
                        $row->product_id = $product->id;

                        $sale_order_item = $this->saveItem('App\SaleOrderItem' , $row);
                    }
                }
            }
        }
    }

    /**
     *
     */
    private function saveItem($className , $data){
        $data->unique_id = $data->id;
        unset($data->id);

        $item = $className::whereUniqueId($data->unique_id)->first();
        if($item){
            $item->update((Array)$data);
        }else{
            $item = $className::create((Array)$data);
        }

        return $item;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getUsers();
        $this->getOrders();
    }
}
