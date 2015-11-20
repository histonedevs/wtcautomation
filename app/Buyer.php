<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    //
    protected $fillable=['unique_id','user_id','name','first_name','middle_initial','last_name','email','phone','address1','address2','address3','zip','city','state','country','orders_count','location_id','deleted_at'];

}
