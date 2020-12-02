<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Tax;

use DateTime;

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
        $activeTax = $taxes->first();
                                    
        $yellowAlert = Car::find($id)->yellow_alert ?? 30;
        $redAlert = Car::find($id)->red_alert ?? 15;

        if((new DateTime($activeTax->expiration_date ?? now())) >= (new DateTime()) ){
            $activeDaysLeft = (new DateTime($activeTax->expiration_date ?? now()) )->diff((new DateTime()))->format('%a') + 1;
        }
        else{
            $activeDaysLeft = -(new DateTime($activeTax->expiration_date ?? now()) )->diff((new DateTime()))->format('%a');
        }

        

        return view('pages.taxes', ['car' => Car::find($id), 
        'taxes' => $taxes, 
        'activeTax' => $activeTax, 
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
    public function edit($car_id, $tax_id)
    {
        $car = Car::find($car_id);
        $tax = Tax::find($tax_id);
        return view('pages.editCarTaxes', ['car' => $car, 'tax' => $tax]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $tax_id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'expiration_date' => 'required|date|after:date',
            'value' => 'required|min:0',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,txt',
            'obs' => 'nullable|string|max:255',
        ]);

        $tax = Tax::find($tax_id);
        $tax->date = $request->input('date');
        $tax->expiration_date = $request->input('expiration_date');
        $tax->value = $request->input('value');
        $tax->obs = $request->input('obs');

         if ($request->hasFile('file')) {
            $car = Car::find($car_id);
            $fileName = 'tax_' . $tax_id . '_' . count($car->taxes) . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('file/tax/'), $fileName);
            $tax->file = 'file/tax/' . $fileName;
        }

        $tax->save();

        return redirect()->route('tax.find', $car_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id, $tax_id)
    {
        $tax = Tax::find($tax_id);
        $tax->delete();
        return back();
    }

    public function showTax($car_id,$id){
        $car = Car::find($car_id);
        $tax = Tax::find($id);
        return view('pages.tax', ['car'=>$car], ['tax'=>$tax]);
    }
}
