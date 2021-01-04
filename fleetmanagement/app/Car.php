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

        return $count;
    }

    private function numEventIssuesTimePeriod($dateStart, $dateEnd, $allEvents, $endDateName)
    {
        $timePeriodEventsExp = $allEvents->whereBetween($endDateName, [$dateStart, $dateEnd]);    
        $timePeriodEventsStart = $allEvents->whereBetween('date', [$dateStart, $dateEnd]);
        $eventPrecedingTimePeriod = $allEvents->where('date', '<', $dateStart)->sortByDesc($endDateName)->take(1)->pluck($endDateName)->first();

        $timePeriodEvents = ($timePeriodEventsExp->merge($timePeriodEventsStart))->sortBy($endDateName);

        $timePeriodEventsDates = $timePeriodEvents->map(function ($event) use ($endDateName) {
            return collect($event->toArray())
                ->only(['id', 'date', $endDateName])
                ->all();
        });

        $timePeriodEventsDatesArray = $timePeriodEventsDates->toArray();

        $count = 0;
        $lastExpDatesAreFuture = false;

        //increments the count if the event preceding the time period has expired before the period's start
        if ($eventPrecedingTimePeriod != null)
        {   
            $dateStart->gt($eventPrecedingTimePeriod) ? $count++ : true;
        }

        //counts any issues pertaining to events that start or end within the time period, 
        //not including the last events' expiration date
        for ($i = 0; $i < count($timePeriodEventsDatesArray) - 1; $i++) {

            $currEvent = $timePeriodEventsDatesArray[$i];
            $nextEvent = $timePeriodEventsDatesArray[$i + 1];

            $currEventExpirationDate = new Carbon($currEvent[$endDateName]); //first event end date
            $nextEventDate = new Carbon($nextEvent['date']); //second event date
            
            $lastExpDatesAreFuture = Carbon::now()->lte($currEventExpirationDate);
            if ($lastExpDatesAreFuture)
                break;

            if ($nextEventDate->gt($currEventExpirationDate))
                $count++;
        }

        //increments the count if the last event expires within the time period
        //(which means there was a time where the event was not renewed)
        if (count($timePeriodEventsDatesArray) > 0) {

            $lastEvent = $timePeriodEventsDatesArray[count($timePeriodEventsDatesArray) - 1];
            $lastEventExpirationDate = new Carbon($lastEvent[$endDateName]);

            $lastExpDateIsFuture = Carbon::now()->lte($lastEventExpirationDate);

            !$lastExpDateIsFuture && $dateEnd->gt($lastEventExpirationDate) ? $count++ : true;
        }

        return $count; 
    }

}
