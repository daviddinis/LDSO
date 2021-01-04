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

    public function numIssuesYear($year)    
    {
        $yearStart = new Carbon('first day of January' . $year);
        $yearEnd = new Carbon('last day of December' . $year);        
        
        return $this->numAllIssuesPeriod($yearStart, $yearEnd);
    }

    public function numIssuesMonth($year, $month)
    {
        $monthStart = Carbon::createFromFormat('Y-m-d H', "$year-$month-1 24")->startOfMonth();
        $monthEnd = $monthStart->copy();
        $monthEnd->endOfMonth()->startOfDay();
        
        return $this->numAllIssuesPeriod($monthStart, $monthEnd);
    }

    private function numAllIssuesPeriod($dateStart, $dateEnd){

        $count = $this->numEventIssuesTimePeriod($dateStart, $dateEnd, $this->taxes, 'expiration_date');
        $count += $this->numEventIssuesTimePeriod($dateStart, $dateEnd, $this->maintenances, 'next_maintenance_date');
        $count += $this->numEventIssuesTimePeriod($dateStart, $dateEnd, $this->inspections, 'expiration_date');
        $count += $this->numEventIssuesTimePeriod($dateStart, $dateEnd, $this->insurances, 'expiration_date');

        return /*$this->model . ' ' . $this->make  . ' ' . $this->license_plate . '  |  ' .*/ $count;
    }

    private function numEventIssuesTimePeriod($dateStart, $dateEnd, $allEvents, $endDateName)
    {
        $yearEventsExp = $allEvents->whereBetween($endDateName, [$dateStart, $dateEnd]);    
        $yearEventsStart = $allEvents->whereBetween('date', [$dateStart, $dateEnd]);

        $yearEvents = ($yearEventsExp->merge($yearEventsStart))->sortBy($endDateName);

        $yearEventsDates = $yearEvents->map(function ($event) use ($endDateName) {
            return collect($event->toArray())
                ->only(['id', 'date', $endDateName])
                ->all();
        });

        $yearEventsDatesArray = $yearEventsDates->toArray();

        $count = 0;
        $lastExpDatesAreFuture = false;

        for ($i = 0; $i < count($yearEventsDatesArray) - 1; $i++) {

            $currEvent = $yearEventsDatesArray[$i];
            $nextEvent = $yearEventsDatesArray[$i + 1];

            $currEventExpirationDate = new Carbon($currEvent[$endDateName]); //first event expiration date
            $nextEventDate = new Carbon($nextEvent['date']); //second event date
            
            $lastExpDatesAreFuture = Carbon::now()->lte($currEventExpirationDate);
            if ($lastExpDatesAreFuture)
                break;

            if ($nextEventDate->gt($currEventExpirationDate))
                $count++;
        }

        if (count($yearEventsDatesArray) > 0) {

            $lastEvent = $yearEventsDatesArray[count($yearEventsDatesArray) - 1];
            $lastEventExpirationDate = new Carbon($lastEvent[$endDateName]);

            $lastExpDateIsFuture = Carbon::now()->lte($lastEventExpirationDate);

            !$lastExpDateIsFuture && $dateEnd->gt($lastEventExpirationDate) ? $count++ : true;
        }

        return $count; 
    }

}
