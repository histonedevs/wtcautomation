<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable=['unique_id','parent_id','name','first_name','last_name','email','merchant_id','auth_token','deleted_at', 'account_title'];

    public function orders()
    {
        return $this->hasMany('App\SaleOrder');
    }

    public function parent(){
        return $this->belongsTo('App\Models\User', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany('App\Models\User', 'parent_id');
    }

}
