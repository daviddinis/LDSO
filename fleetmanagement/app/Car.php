<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $timestamps  = false;

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function taxes() {
        return $this->hasMany('App\Tax');
    }

    public function maintenances() {
        return $this->hasMany('App\Maintenance');
    }

    public function inspections() {
        return $this->hasMany('App\Inspection');
    }

    public function insurances() {
        return $this->hasMany('App\Insurance');
    }

    public function drivers() {
        return $this->belongsToMany('App\Driver')->withPivot('start_date', 'end_date');
    }
}
