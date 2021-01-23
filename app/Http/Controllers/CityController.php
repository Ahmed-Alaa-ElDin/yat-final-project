<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\City;


class CityController extends Controller
{
    public function new_city()
    {
        $countries = Country::all();

        return view('city.new_city_form', compact('countries'));
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'name'          =>       ['required','string','max:20'],
            'country'       =>       ['required'],
        ])->validate();

        // Add to Database
        City::create([
            'name'            =>      $request->name,
            'country_id'      =>      $request->country,
        ]);

        return redirect()->route('dashboard')->with('message', 'City Added Successfully')->with('message_type','good');
    }

    public function view_cities()
    {
        $cities = City::with('states')->with('country')->get();

        return view('city.view_cities', compact('cities'));
    }

    public function delete_city(Request $request)
    {
        // delete City

        City::find($request->id)->delete();

        return redirect()->route('cities.view')->with('message', 'City Deleted Successfully')->with('message_type','good');
    }

    public function edit_city($id)
    {
        $city = City::find($id);
        $countries = Country::all();

        return view('city.edit_city_form',compact('city','countries'));
    }

    public function save_edit_city(Request $request)
    {
        global $city;
        $city = City::find($request->id);
        
        // Validation 
        Validator::make($request->all(), [
            'name'          =>       ['required','string','max:20'],
            'country'       =>       ['required'],
        ])->validate();   

        // Updating
        $city->update([
            'name'            =>      $request->name,
            'country_id'      =>      $request->country,
        ]);

        return redirect()->route('cities.view')->with('message', 'City Data Updated Successfully')->with('message_type','good');
    }
}
