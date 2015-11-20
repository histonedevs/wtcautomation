<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable=['unique_id','postal_code','ward','sublocality_level_3','sublocality_level_2','sublocality_level_1','sublocality','locality','administrative_area_level_3','administrative_area_level_2','administrative_area_level_1','country','formatted_address','location_lat','location_lng','location_type','partial_match'];
}
