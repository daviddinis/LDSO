<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Maintenance;


class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $maintenances = Maintenance::get()->where('car_id', '=', $id);
        return view('pages.maintenances', ['car' => Car::find($id),
                                            'maintenances' => $maintenances]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        return view('pages.addMaintenance', ['car_id' => $id]);
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
            'next_maintenance_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'mileage' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,txt'
        ]);

        $maintenance = new Maintenance;
        $maintenance->date = $request['date'];
        $maintenance->next_maintenance_date = $request['next_maintenance_date'];
        $maintenance->value = $request['value'];
        $maintenance->kilometers = $request['mileage'];
        $maintenance->obs = $request['observations'];
        $maintenance->car_id = $id;

         if ($request->hasFile('file')) {
            $car = Car::find($id);
            $fileName = 'maintenance_' . $id . '_' . count($car->maintenances) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/maintenance/'), $fileName);
            $maintenance->file = 'file/maintenance/' . $fileName;
        }

        $maintenance->save();

        return redirect()->route('maintenance.find', $id);
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
        $maintenance = Maintenance::find($id);
        return view('pages.editMaintenance')->with('maintenance', $maintenance);
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
        $this->validate($request, [
            'date' => 'required|date',
            'next_maintenance_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'mileage' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,txt'
        ]);

        $maintenance = Maintenance::find($id);
        $maintenance->date = $request->input('date');
        $maintenance->next_maintenance_date = $request->input('next_maintenance_date');
        $maintenance->value = $request->input('value');
        $maintenance->kilometers = $request->input('mileage');
        $maintenance->obs = $request->input('observations');
        
         if ($request->hasFile('file')) {
            $car = Car::find($id);
            $fileName = 'maintenance_' . $id . '_' . count($car->maintenances) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/maintenance/'), $fileName);
            $maintenance->file = 'file/maintenance/' . $fileName;
        }

        $maintenance->save();

        return redirect()->route('maintenance.find', $maintenance->car_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $maintenance = Maintenance::find($id);
        $maintenance->delete();
        return back();
    }
}
