<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $fillable=['deleted_at','user_id','recipient','product_id','text','sent','visited','error'];


    protected $dates = ['deleted_at'];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
