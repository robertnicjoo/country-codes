<?php

namespace Irando\CountryCodes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryCodes;

class CountryCodesontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('country-codes.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = CountryCodes::all();
        // return view('irando.country-codes.list', compact('countries',));
        return view('country-codes::list', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CountryCodes::create([
            'code' => $request->code,
            'country' => $request->country,
            'phone_name' => $request->phone_name,
            'phone_code' => $request->phone_code,
        ]);
        return redirect()->route('country-codes.create');
    }

    /**
     * Show the form for editing the specified resource.
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
        $countries = CountryCodes::all();
        $country = CountryCodes::findOrFail($id);
        return view('country-codes::list', compact('countries', 'country'));
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
        $country = CountryCodes::findOrFail($id);
        $country->code = $request->code;
        $country->country = $request->country;
        $country->phone_name = $request->phone_name;
        $country->phone_code = $request->phone_code;
        $country->save();
        return redirect()->route('country-codes.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = CountryCodes::findOrFail($id);
        $country->delete();
        return redirect()->route('country-codes.create');
    }
}
