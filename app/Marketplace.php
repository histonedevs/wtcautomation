<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    protected $fillable=['name','marketplace_id', 'amazon_url', 'mws_domain'];
}
