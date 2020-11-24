<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
        return $this->belongsToMany('App\Driver')->withPivot('id', 'start_date', 'end_date');
    }

    public function issues(){
        $count = $this->taxes->where( 'expiration_date', '<', Carbon::now()->addDays(30))->count();
        $count += $this->maintenances->where( 'next_maintenance_date', '<', Carbon::now()->addDays(30))->count();
        $count += $this->inspections->where( 'expiration_date', '<', Carbon::now()->addDays(30))->count();
        $count += $this->insurances->where( 'expiration_date', '<', Carbon::now()->addDays(30))->count();
        return $count;
    }

    public function currentDriver(){
        $driver = $this->drivers()->wherePivot('end_date', '=', null)->orWherePivot('end_date', '>', Carbon::now())->get();
        if(count($driver) == 0){
            return 'available';
        }
        else{
            return $driver[0]['name'];
        }
    }
    
}
