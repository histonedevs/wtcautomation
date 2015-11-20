<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrderItem extends Model
{
    protected $fillable=['unique_id','sale_order_id','product_id','item_id','quantity_ordered','quantity_shipped','currency','item_price','item_discount','item_tax','shipping_price','shipping_discount','shipping_tax','giftwrap_price','giftwrap_tax','giftwrap_message','giftwrap_level','cod_fee','cod_fee_discount','price_designation','delivery_start_date','delivery_end_date','promotion_ids','deleted_at'];
}
