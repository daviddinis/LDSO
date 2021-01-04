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
        $userId = User::find(Auth::user()->id)->company->id;
        $cars = Car::where('company_id', '=', $userId)->get();
        $carIds = $cars->pluck('id');

        $maintenances = Maintenance::whereIn('car_id', $carIds)->get();
        $insurances = Insurance::whereIn('car_id', $carIds)->get();
        $inspections = Inspection::whereIn('car_id', $carIds)->get();
        $taxes = Tax::whereIn('car_id', $carIds)->get();
        $allTaxes = Tax::whereIn('car_id', $carIds);

        $all_maintenaces = Maintenance::whereIn('car_id', $carIds)->orderBy('date');

        $history = [];
        foreach ($maintenances as $maintenance){
                array_push($history,$maintenance);
        }
        for ($i = 0; $i < sizeof($maintenances) ; $i++) {
            $history[$i]->type = "maintenance";
        }
        foreach ($insurances as $insurance){
            array_push($history,$insurance);
        }
        for ($i = 0; $i < sizeof($insurances) ; $i++) {
            $history[$i+sizeof($maintenances)]->type = "insurance";
        }
        foreach ($inspections as $inspection){
            array_push($history,$inspection);
        }
        for ($i = 0; $i < sizeof($inspections) ; $i++) {
            $history[$i+sizeof($maintenances)+sizeof($insurances)]->type = "inspection";
        }
        foreach ($taxes as $tax){
            array_push($history,$tax);
        }
        for ($i = 0; $i < sizeof($taxes) ; $i++) {
            $history[$i+sizeof($maintenances)+sizeof($insurances)+sizeof($inspections)]->type = "tax";
        }

        array_sort_by_column($history, 'date');

        return view('pages.history', ['cars' => $cars, 
                                    'maintenances' => $maintenances, 
                                    'insurances' => $insurances,
                                    'inspections' => $inspections,
                                    'taxes' => $taxes,
                                    'allTaxes' =>$allTaxes->paginate(15),
                                    'history' => $history,
                                    'allMaintenances' => $all_maintenaces->paginate(15)]);
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

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
