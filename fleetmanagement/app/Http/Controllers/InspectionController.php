<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Inspection;

use DateTime;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $inspections = Inspection::where('car_id', '=', $id)->orderBy('date', 'DESC');
        $activeInspection = $inspections->first();
        
        $yellowAlert = Car::find($id)->yellow_alert ?? 30;
        $redAlert = Car::find($id)->red_alert ?? 15;

        $activeDaysLeft = (new DateTime($activeInspection->expiration_date ?? now()))->diff(now())->format('%a');

        if($activeInspection != null)
        { 
            $activeDaysLeft *= $activeInspection->expiration_date < now() ? -1 : 1;
        }

        return view('pages.inspections', ['car' => Car::find($id), 
            'inspections' => $inspections->paginate(10), 
            'activeInspection' => $activeInspection, 
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
        return view('pages.addInspection', ['car_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:pdf,jpeg,png,jpg,gif,svg,txt|max:1000'
        ]);

        $inspection = new Inspection;
        $inspection->date = $request['date'];
        $inspection->expiration_date = $request['expiration_date'];
        $inspection->value = $request['value'];
        $inspection->obs = $request['observations'];
        $inspection->car_id = $id;

            if ($request->hasFile('file')) {
            $car = Car::find($id);
            $fileName = 'inspection_' . $id . '_' . count($car->inspections) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/inspection/'), $fileName);
            $inspection->file = 'file/inspection/' . $fileName;
        }

        $inspection->save();

        return redirect()->route('inspection.find', $id);
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
    public function edit($car_id, $inspection_id)
    {
        $car = Car::find($car_id);
        $inspection = Inspection::find($inspection_id);
        return view('pages.editInspection', ['car' => $car, 'inspection' => $inspection]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $inspection_id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:pdf,jpeg,png,jpg,gif,svg,txt'
        ]);

        $inspection = Inspection::find($inspection_id);
        $inspection->date = $request->input('date');
        $inspection->expiration_date = $request->input('expiration_date');
        $inspection->value = $request->input('value');
        $inspection->obs = $request->input('observations');

         if ($request->hasFile('file')) {
            $car = Car::find($car_id);
            $fileName = 'inspection_' . $inspection_id . '_' . count($car->inspections) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/inspection/'), $fileName);
            $inspection->file = 'file/inspection/' . $fileName;
        }

        $inspection->save();

        return redirect()->route('inspection.find', $car_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id, $inspection_id)
    {
        $inspection = Inspection::find($inspection_id);
        $inspection->delete();
        return back();
    }
}
