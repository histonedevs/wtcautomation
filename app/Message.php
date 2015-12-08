<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $fillable=['deleted_at','user_id','recipient','campaign_id','text','sent','visited_at','error', 'stars'];


    protected $dates = ['deleted_at'];

    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }
}
