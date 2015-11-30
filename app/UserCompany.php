<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = ['company_name','logo'];
}
