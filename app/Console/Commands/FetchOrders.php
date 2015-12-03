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

define('INVALID_AUTH' , 1);
define('INVALID_ARGUMENT' , 2);
define('INVALID_USER' , 3);

class FetchOrders extends Command
{
    protected static $error_codes = [
        'INVALID_AUTH' => INVALID_AUTH,
        'INVALID_ARGUMENT' => INVALID_ARGUMENT,
        'INVALID_USER' => INVALID_USER,
    ];

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
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @param $url
     * @return array
     * @throws \Exception
     */
    private function callAPI($url){
        $curl = new Curl();
        $curl->setConnectTimeout(3600);

        $api_url = env("API_URL")."/api/{$url}";

        $r = $curl->get($api_url,
            array(
                'email' =>  env('API_USERNAME'),
                'password' => env('API_PASSWORD')
            )
        );

        print $api_url."\n";

        if(@isset($r->error)){
            throw new \Exception($r->error, self::$error_codes[$r->error_code]);
        }

        if(!$r && !is_array($r)){
            throw new \Exception("No data returned");
        }

        return $r;
    }


    /**
     * @param $user
     * @return array
     * @throws \Exception
     */
    private function getMoreOrders($user){
        $last_updated_at = 0;

        $last_update = SaleOrder::where('user_id', $user->id)->orderBy('last_updated_at', 'DESC')->take(1)->first();
        if ($last_update) {
            $last_updated_at = $last_update->last_updated_at->timestamp;
            print "Will get after : ".$last_update->last_updated_at->format('c')."\n";
        }

        return $this->callAPI("orders/list/{$user->unique_id}/{$last_updated_at}");
    }

    /**
     * @throws \Exception
     */
    private function getUsers(){
        foreach ($this->callAPI('users') as $record) {
            $account = $this->saveItem('App\Account',$record);
            foreach ($record->children as $row) {
                $row->parent_id = $account->id;
                $this->saveItem('App\Account',$row);
            }
        }
    }


    private function getProducts(){
        foreach (Account::all() as $user) {
            try {
                foreach ($this->callAPI("products/list/{$user->unique_id}") as $record) {
                    $this->saveItem('App\Product', $record);
                }
            }catch (\Exception $ex){
                if($ex->getCode() == INVALID_USER){
                    continue;
                }else{
                    print $ex->getTraceAsString();
                    throw $ex;
                }
            }
        }
    }

    /**
     *
     */
    private function getOrders(){
        $users = Account::all();
        foreach ($users as $user) {
            try {
                $r = $this->getMoreOrders($user);
                while (count($r) > 0) {
                    foreach ($r as $record) {
                        if ($record->buyer_id && $record->buyer) {
                            if ($record->buyer->location) {
                                $location = $this->saveItem('App\Location', $record->buyer->location);
                                $record->buyer->location_id = $location->id;
                            }

                            $record->buyer->user_id = Account::whereUniqueId($record->buyer->user_id)->first()->id;
                            $buyer = $this->saveItem('App\Buyer', $record->buyer);
                            $record->buyer_id = $buyer->id;
                        }

                        $record->user_id = Account::whereUniqueId($record->user_id)->first()->id;
                        $sale = $this->saveItem('App\SaleOrder', $record);

                        if ($record->sale_order_items) {
                            foreach ($record->sale_order_items as $row) {
                                if ($row->product) {
                                    $row->product->user_id = $sale->user_id;
                                    $product = $this->saveItem('App\Product', $row->product);
                                    $row->product_id = $product->id;
                                }
                                $row->sale_order_id = $sale->id;
                                $sale_order_item = $this->saveItem('App\SaleOrderItem', $row);
                            }
                        }
                    }

                    $r = $this->getMoreOrders($user);
                }
            }catch (\Exception $ex){
                if($ex->getCode() == INVALID_USER){
                    continue;
                }else{
                    print $ex->getTraceAsString();
                    throw $ex;
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
        $this->getProducts();
    }
}
