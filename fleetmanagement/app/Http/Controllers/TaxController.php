<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Tax;


class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $taxes = Tax::get()->where('car_id', '=', $id)->sortByDesc('date');
        return view('pages.taxes', ['car' => Car::find($id),
                                            'taxes' => $taxes]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        return view('pages.addTax', ['car_id' => $id]);
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
            'expiration_date' => 'required|date|after:date',
            'value' => 'required|min:0',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,txt',
            'obs' => 'nullable|string|max:255',
        ]);

        $tax = new Tax;
        $tax->date = $request['date'];
        $tax->expiration_date = $request['expiration_date'];
        $tax->value = $request['value'];
        $tax->obs = $request['obs'];
        $tax->car_id = $id;

         if ($request->hasFile('file')) {
            $car = Car::find($id);
            $fileName = 'tax_' . $id . '_' . count($car->taxes) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/tax/'), $fileName);
            $tax->file = 'file/tax/' . $fileName;
        }

        $tax->save();

        return redirect()->route('tax.find', $id);
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
    public function edit($car_id, $maintenance_id)
    {
        $car = Car::find($car_id);
        $maintenance = Maintenance::find($maintenance_id);
        return view('pages.editMaintenance', ['car' => $car, 'maintenance' => $maintenance]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $maintenance_id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'next_maintenance_date' => 'nullable|date|after:date',
            'value' => 'required|min:0',
            'mileage' => 'required|min:0',
            'observations' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,txt'
        ]);

        $maintenance = Maintenance::find($maintenance_id);
        $maintenance->date = $request->input('date');
        $maintenance->next_maintenance_date = $request->input('next_maintenance_date');
        $maintenance->value = $request->input('value');
        $maintenance->kilometers = $request->input('mileage');
        $maintenance->obs = $request->input('observations');

         if ($request->hasFile('file')) {
            $car = Car::find($car_id);
            $fileName = 'maintenance_' . $maintenance_id . '_' . count($car->maintenances) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/maintenance/'), $fileName);
            $maintenance->file = 'file/maintenance/' . $fileName;
        }

        $maintenance->save();

        return redirect()->route('maintenance.find', $car_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id, $maintenance_id)
    {
        $maintenance = Maintenance::find($maintenance_id);
        $maintenance->delete();
        return back();
    }
}
