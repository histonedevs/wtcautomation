<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegativeResponse extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message(){
        return $this->belongsTo('App\Message');
    }
}
