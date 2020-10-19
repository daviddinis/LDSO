<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Driver;
use App\Company;
use App\User;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) return redirect('/login');
        $drivers = Driver::orderBy('name','asc')->get();
        return view('pages.driverList')->with('drivers', $drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) return redirect('/login');
        return view('pages.addDriver');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z_-]*$/',
        ]);

        $driver = new Driver;
        $driver->name = $request->input('name');
        $driver->email = $request->input('email');
        $driver->drivers_license = $request->input('license');
        $driver->company_id = User::find(Auth::user()->id)->company_id;
        $driver->save();
        return redirect('/driver');
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
        $driver = Driver::find($id);
        return view('pages.editDriver')->with('driver', $driver);
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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z_-]*$/',
        ]);

        $driver = Driver::find($id);
        $driver->name = $request->input('name');
        $driver->email = $request->input('email');
        $driver->drivers_license = $request->input('drivers_license');
        $driver->company_id = User::find(Auth::user()->id)->company_id;
        $driver->save();
        return redirect('/driver');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
        return redirect('/driver');
    }
}
