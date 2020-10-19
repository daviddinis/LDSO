<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps  = false;


    public function driver() {
        return $this->hasMany('App\Driver');
      }
      public function users() {
        return $this->hasMany('App\Users');
      }
}
