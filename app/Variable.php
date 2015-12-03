<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Variable extends Model
{
    protected $fillable = ['name','value'];

    protected $dates = ['deleted_at'];
}
