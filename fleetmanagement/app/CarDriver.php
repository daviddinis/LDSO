<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarDriver extends Model
{
    protected $table = 'car_driver';

    public $timestamps  = false;


    public function driver()
    {
       return $this->belongsTo('App\Driver');
    }
}
