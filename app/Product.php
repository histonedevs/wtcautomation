<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['unique_id','product_id_type','user_id','title','description','sku','product_id','fnsku','asin','condition','sub_condition','fulfilment_channel','image_url','cost','price','shipping_price','buybox_price','sales_rank','stock','open_date','deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaign(){
        return $this->hasOne('App\Campaign');
    }
}
