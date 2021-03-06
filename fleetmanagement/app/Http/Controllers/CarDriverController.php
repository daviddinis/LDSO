<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CarDriver;
use App\Car;


class CarDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cardriver = new CarDriver();

        $request->validate([
            'car_id' => 'required',
            'driver_id' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $cardriver->car_id = $request['car_id'];
        $cardriver->driver_id = $request['driver_id'];
        $cardriver->start_date = $request['start_date'];
        $cardriver->end_date = $request['end_date'];
        $cardriver->save();

        return redirect()->route('car.show', $request['car_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $carDriver = CarDriver::find($id);
        $carId = $carDriver->car_id;
        CarDriver::destroy($id);
        return redirect()->route('car.show', $carId);
    }

    public function showDrivers($car_id){
        $car = Car::find($car_id);
        $drivers = $car->drivers()->orderBy('end_date', 'DESC');

        $driverChartValues = CarDriver::selectRaw('drivers.name as x, count(driver_id) as y')
            ->leftJoin('drivers', 'drivers.id', '=', 'car_driver.driver_id')
            ->where('car_id', '=', $car->id)
            ->groupBy('x')
            ->get();

        return view('pages.driverHistory')->with('drivers', $drivers->paginate(15))->with('car_id' , $car_id)->with('driverChartValues', $driverChartValues);        
    }

}
