<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Car;
use App\Company;
use App\User;

class CarController extends Controller
{

    public function index()
    {
        if (!Auth::check()) return redirect('/login');
        $cars = Car::get();
        return view('pages.cars')->with('cars', $cars);
    }

    public function form()
    {
        if (!Auth::check()) return redirect('/login');

        return view('pages.addCar');
    }

    public function create(Request $request)
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
        return redirect('/');

    }

    public function show($id) {
        $car = Car::find($id);
        return view('pages.car')->with('car', $car);
    }
}
