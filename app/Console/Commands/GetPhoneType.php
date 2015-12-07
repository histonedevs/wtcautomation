<?php

namespace App\Console\Commands;

use App\Api\Twilio;
use App\Buyer;
use Illuminate\Console\Command;

class GetPhoneType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:phone_types';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $buyers = Buyer::whereNotNull("phone")
            ->where("phone" , "!=" , '')
            ->whereNull("carrier")
            ->whereNull("phone_type")
            ->take(5)->get();
        foreach($buyers as $buyer){
            $carrier = Twilio::lookup($buyer->phone, $buyer->country);
            if($carrier){
                $buyer->phone_type = $carrier->type;
                $buyer->carrier = $carrier->name;
                $buyer->save();
            }
        }
    }
}
