<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    protected $fillable=['unique_id','user_id','buyer_id','amazon_order_id','order_status','fulfillment_channel','sales_channel','carrier','tracking_number','purchased_at','last_updated_at','deleted_at'];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
