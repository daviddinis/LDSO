<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Car;
use App\Company;
use App\Driver;
use App\CarDriver;
use App\User;
use App\Tax;
use App\Maintenance;
use App\Insurance;
use App\Inspection;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) return redirect('/login');
        $cars = Car::where('company_id', '=', User::find(Auth::user()->id)->company->id)->get();
        $carIds = $cars->pluck('id');


        $maintenanceCosts = Maintenance::selectRaw('concat(EXTRACT(year from date), \'-\', EXTRACT(month from date)) as yearandmonth, sum(value) as costs')
            ->whereIn('maintenances.car_id', $carIds)
            ->groupBy('yearandmonth')
            ->limit(12)
            ->orderBy('yearandmonth')
            ->get();
        $maintenanceValues = $maintenanceCosts->pluck('costs');
        
        $taxCosts = Tax::selectRaw('concat(EXTRACT(year from date), \'-\', EXTRACT(month from date)) as yearandmonth, sum(value) as costs')
            ->whereIn('taxes.car_id', $carIds)
            ->groupBy('yearandmonth')
            ->limit(12)
            ->orderBy('yearandmonth')
            ->get();        
        $taxValues = $taxCosts->pluck('costs');

        $InsuranceCosts = Insurance::selectRaw('concat(EXTRACT(year from date), \'-\', EXTRACT(month from date)) as yearandmonth, sum(value) as costs')
            ->whereIn('insurances.car_id', $carIds)
            ->groupBy('yearandmonth')
            ->limit(12)
            ->orderBy('yearandmonth')
            ->get();        
        $InsuranceValues = $InsuranceCosts->pluck('costs');

        $InspectionCosts = Inspection::selectRaw('concat(EXTRACT(year from date), \'-\', EXTRACT(month from date)) as yearandmonth, sum(value) as costs')
            ->whereIn('inspections.car_id', $carIds)
            ->groupBy('yearandmonth')
            ->limit(12)
            ->orderBy('yearandmonth')
            ->get();        
        $InspectionValues = $InspectionCosts->pluck('costs');
        

        $maintenanceLabels = $maintenanceCosts->pluck('yearandmonth');

        return view('pages.cars', [
            'costs' => $maintenanceCosts, 
            'maintenanceLabels' => $maintenanceLabels, 
            'maintenanceValues'=> $maintenanceValues, 
            'taxValues' => $taxValues, 
            'insuranceValues' => $InsuranceValues, 
            'carIds' => $carIds,
            'inspectionValues' => $InspectionValues])->with('cars', $cars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) return redirect('/login');

        return view('pages.addCar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $car = new Car();
        $car->make = $request->input('brand');
        $car->model = $request->input('model');
        $car->license_plate = $request->input('plate');
        $car->company_id = User::find(Auth::user()->id)->company->id;
        $car->date_acquired = $request->input('date');
        $car->value = 0;

        if ($request->hasFile('image')) {
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = $request->input('plate') . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('img'), $imageName);
            $car->image = $imageName;
        }

        if ($request->input('mileage') != NULL) {
            $car->kilometers = $request->input('mileage');
        }

        $car->save();
        return redirect('/car');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::check()) return redirect('/login');
        $car = Car::find($id);
        return view('pages.car', array_merge(['car' => $car, 'drivers' => Driver::all()], $this->getEventExpirationDates($car) ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();
        return redirect('/car');
    }

    public function showManageAlerts($id)
    {
        if (!Auth::check()) return redirect('/login');
        $car = Car::findOrFail($id);

        return view('pages.carSettings', array_merge([
            'car' => $car] , $this->getEventExpirationDates($car)
        ));
    }

    private function getEventExpirationDates($car){

        $tax = $this->getCurrentTax($car);
        $taxDate = $tax != null ? $tax->expiration_date : null;

        $inspection = $this->getCurrentInspection($car);
        $inspectionDate = $inspection != null ? $inspection->expiration_date : null;

        $insurance = $this->getCurrentInsurance($car);
        $insuranceDate = $insurance != null ? $insurance->expiration_date : null;

        $maintenance = $this->getCurrentMaintenance($car);
        $maintenanceDate = $maintenance != null ? $maintenance->date : null;

        return ['taxDate' => $taxDate,
            'inspectionDate' => $inspectionDate, 'insuranceDate' => $insuranceDate,
            'maintenanceDate' => $maintenanceDate
        ];
    }

    //updates the car alert settings?
    public function editAlerts(Request $request, $id)
    {

        //update alert settings TODO:implement it
        $validator = Validator::make($request->all(), [
            'yellow' => 'required|integer|min:1|max:365|gt:red',
            'red' => 'required|integer|min:1|max:365|lt:yellow'
        ]);

        $validator->validate();

        $car = Car::findOrFail($id);

        $input_yellow = $request->input('yellow');
        $input_red = $request->input('red');

        if ($car->yellow_alert  != $input_yellow && $input_yellow != null)
            $car->yellow_alert = $input_yellow;
        if ($car->red_alert  != $input_red && $input_red != null)
            $car->red_alert = $input_red;
        $car->save();

        return redirect()->back();
    }

    private function getCurrentTax($car)
    {

        return $car->taxes()->orderBy('date', 'desc')->first();
    }

    private function getCurrentInspection($car)
    {

        return $car->inspections()->orderBy('date', 'desc')->first();
    }

    private function getCurrentInsurance($car)
    {

        return $car->insurances()->orderBy('date', 'desc')->first();
    }

    private function getCurrentMaintenance($car)
    {

        return $car->maintenances()->orderBy('date', 'desc')->first();
    }
    
    /**
     * Assign driver to car
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {
    }

}
