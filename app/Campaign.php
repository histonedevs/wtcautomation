<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Campaign
 * @package App
 */
class Campaign extends Model
{
    protected $fillable = ['user_id' , 'product_id', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Account', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
