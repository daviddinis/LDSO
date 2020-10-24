<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    public $timestamps  = false;

    public function car() {
        return $this->belongsTo('App\Car');
    }


}
