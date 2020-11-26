<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Car;
use App\Company;
use App\Driver;
use App\User;
use App\Tax;
use App\Maintenance;
use App\Insurance;
use App\Inspection;

class HistoryController extends Controller
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
        $maintenances = Maintenance::get();
        $insurances = Insurance::get();
        $inspections = Inspection::get();
        $taxes = Tax::get();

        return view('pages.history', ['cars' => $cars, 
                                    'maintenances' => $maintenances, 
                                    'insurances' => $insurances,
                                    'inspections' => $inspections,
                                    'taxes' => $taxes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
