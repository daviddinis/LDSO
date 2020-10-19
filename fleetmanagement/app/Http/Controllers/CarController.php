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

    public function form()
    {
        if (!Auth::check()) return redirect('/login');

        return view('pages.addCar');
    }

    public function create(Request $request)
    {
        $car = new Car();
        $car->brand = $request->input('brand');
        $car->model = $request->input('model');
        $car->license_plate = $request->input('plate');
        $car->company_id = User::find(Auth::user()->id)->company;
        $car->date_acquired = $request->input('date');


        if ($request->input('image') != NULL) {
            request()->validate([

                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);
            $imageName = $car->id . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('img'), $imageName);
            $car->image + $imageName;
        }

        if ($request->input('mileage') != NULL) {
            $car->kilometers = $request->input('mileage');
        }

        if ($request->input('value') != NULL) {
            $car->value = $request->input('value');
        }
        $car->save();
        return redirect('/');
    }
}
