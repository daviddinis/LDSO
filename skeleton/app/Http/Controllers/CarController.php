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

    public function form(){
        if (!Auth::check()) return redirect('/login');

        return view('pages.addCar');
    }

    public function create(Request $request){
        $car = new Car();
        $car->brand = $request->input('brand');
        $car->model = $request->input('model');
        $car->license_plate = $request->input('plate');
        $car->company = User::find(Auth::user()->id)->company;
        $car->currently_using = NULL;
        $car->save();
            return redirect('/');
    }
   
}