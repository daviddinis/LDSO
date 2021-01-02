<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Car extends Model
{
    use HasFactory;


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
    
    public function carDriver() {
        return $this->hasMany('App\CarDriver');
    }

    public function numIssues(){
        $count = $this->taxes->where( 'expiration_date', '<', Carbon::now()->addDays(30))->sortByDesc('expiration_date')->take(1)->count();
        $count += $this->maintenances->where( 'next_maintenance_date', '<', Carbon::now()->addDays(30))->sortByDesc('expiration_date')->take(1)->count();
        $count += $this->inspections->where( 'expiration_date', '<', Carbon::now()->addDays(30))->sortByDesc('expiration_date')->take(1)->count();
        $count += $this->insurances->where( 'expiration_date', '<', Carbon::now()->addDays(30))->sortByDesc('expiration_date')->take(1)->count();
        return $count;
    }

    public function issues() {
        $taxIssue = $this->taxes->sortBy('expiration_date')->take(1);
        $maintenanceIssue = $this->maintenances->sortByDesc('next_maintenance_date')->take(1);
        $inspectionIssue = $this->inspections->sortByDesc('expiration_date')->take(1);
        $insuranceIssue = $this->insurances->sortByDesc('expiration_date')->take(1);

        $listofIssues = ['Tax' => $taxIssue, 'Maintenance' => $maintenanceIssue, 'Inspection' => $inspectionIssue, 'Insurance' => $insuranceIssue];

        return $listofIssues;
    }

}
