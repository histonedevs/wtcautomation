<?php

namespace App\Console\Commands;

use App\Account;
use App\Location;
use Carbon\Carbon;
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
    protected $signature = 'api:fetch_orders {--user=all} {--again}';

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

    private function getMoreOrdersAfter($user, Carbon $date=null){
        $last_updated_at = 0;
        if($date){
            $last_updated_at = $date->timestamp;
        }

        $c = new Carbon;
        $c->timestamp = $last_updated_at;
        print "Will get after : ".$c->format('c')."\n";

        return $this->callAPI("orders/list/{$user->unique_id}/{$last_updated_at}");
    }

    /**
     * @param $user
     * @return array
     * @throws \Exception
     */
    private function getMoreOrders($user){
        $last_update = SaleOrder::where('user_id', $user->id)->orderBy('last_updated_at', 'DESC')->take(1)->first();
        if ($last_update) {
            return $this->getMoreOrdersAfter($user, $last_update->last_updated_at);
        }else{
            return $this->getMoreOrdersAfter($user);
        }
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
                    $record->user_id = $user->id;
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
     * @param $r
     * @return Carbon
     */
    private function saveOrders($r){
        $date = null;

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
                    $this->saveItem('App\SaleOrderItem', $row);
                }
            }

            $date = Carbon::parse($record->last_updated_at);
        }

        return $date;
    }

    /**
     *
     */
    private function getOrders(){
        $user = $this->option('user');
        $users = [];
        if($user == "all"){
            $users = Account::all();

        }else if(is_numeric($user)){
            print $user. "\n";
            $users = [Account::find($user)];
        }

        foreach ($users as $user) {
            if($this->option("again")){
                $this->getOrdersAgain($user);
            }else{
                $this->getOrdersForUser($user);
            }
        }
    }

    private function getOrdersForUser($user){
        try {
            $last = null;
            $r = $this->getMoreOrders($user);
            while (count($r) > 0) {
                $date = $this->saveOrders($r);
                if($last && $last->diffInSeconds($date) > 0){
                    $last = $date;
                    $r = $this->getMoreOrders($user);
                }else{
                    break;
                }
            }
        }catch (\Exception $ex){
            if($ex->getCode() == INVALID_USER){
                return;
            }else{
                print $ex->getTraceAsString();
                throw $ex;
            }
        }
    }

    private function getOrdersAgain($user){
        $last = null;
        $date = Carbon::createFromTimestamp(0);
        try {
            $r = $this->getMoreOrdersAfter($user, $date);
            while (count($r) > 0) {
                $last = $this->saveOrders($r);
                if($last->diffInSeconds($date) > 0){
                    $date = $last;
                    $r = $this->getMoreOrdersAfter($user, $date);
                }else{
                    break;
                }
            }
        }catch (\Exception $ex){
            if($ex->getCode() == INVALID_USER){

            }else{
                print $ex->getTraceAsString();
                throw $ex;
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
