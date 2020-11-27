<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Insurance;

use DateTime;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $insurances = Insurance::get()->where('car_id', '=', $id)->sortByDesc('date');
        $activeInsurance = $insurances->shift();
        
        $yellowAlert = Car::find($id)->yellow_alert ?? 30;
        $redAlert = Car::find($id)->red_alert ?? 15;

        //$activeDaysLeft = (new DateTime($activeInsurance->expiration_date ?? now()))->diff(now())->format('%a');

        if((new DateTime($activeInsurance->expiration_date ?? now())) >= (new DateTime()) ){
            $activeDaysLeft = (new DateTime($activeInsurance->expiration_date ?? now()) )->diff((new DateTime()))->format('%a') + 1;
        }
        else{
            $activeDaysLeft = -(new DateTime($activeInsurance->expiration_date ?? now()) )->diff((new DateTime()))->format('%a');
        }

        return view('pages.insurances', ['car' => Car::find($id), 
            'insurances' => $insurances, 
            'activeInsurance' => $activeInsurance, 
            'activeDaysLeft' => $activeDaysLeft,
            'yellowAlert' => $yellowAlert, 
            'redAlert' => $redAlert]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('pages.addInsurance', ['car_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
         //
         $this->validate($request, [
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:pdf,jpeg,png,jpg,gif,svg,txt|max:1000'
        ]);

        $insurance = new Insurance;
        $insurance->date = $request['date'];
        $insurance->expiration_date = $request['expiration_date'];
        $insurance->value = $request['value'];
        $insurance->obs = $request['observations'];
        $insurance->car_id = $id;

         if ($request->hasFile('file')) {
            $car = Car::find($id);
            $fileName = 'insurance_' . $id . '_' . count($car->insurances) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/insurance/'), $fileName);
            $insurance->file = 'file/insurance/' . $fileName;
        }

        $insurance->save();

        return redirect()->route('insurance.find', $id);
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
    public function edit($car_id, $insurance_id)
    {
        $car = Car::find($car_id);
        $insurance = Insurance::find($insurance_id);
        return view('pages.editInsurance', ['car' => $car, 'insurance' => $insurance]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $insurance_id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:pdf,jpeg,png,jpg,gif,svg,txt'
        ]);

        $insurance = Insurance::find($insurance_id);
        $insurance->date = $request->input('date');
        $insurance->expiration_date = $request->input('expiration_date');
        $insurance->value = $request->input('value');
        $insurance->obs = $request->input('observations');

         if ($request->hasFile('file')) {
            $car = Car::find($car_id);
            $fileName = 'insurance_' . $insurance_id . '_' . count($car->insurances) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/insurance/'), $fileName);
            $insurance->file = 'file/insurance/' . $fileName;
        }

        $insurance->save();

        return redirect()->route('insurance.find', $car_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id, $insurance_id)
    {
        $insurance = Insurance::find($insurance_id);
        $insurance->delete();
        return back();

    }
}
