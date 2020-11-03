<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Car;
use App\Company;
use App\Driver;
use App\User;

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

        return view('pages.cars')->with('cars', $cars);
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
        return view('pages.car', ['car' => $car, 'drivers' => Driver::all()]);
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

    /**
     * Assign driver to car
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {

    }

    public function showEditCar($id){
        $car = Car::find($id);
        return view('pages.editCar', ['car'=>$car]);
    }
}
