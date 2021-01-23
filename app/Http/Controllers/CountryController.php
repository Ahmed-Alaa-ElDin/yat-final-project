<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;


class CountryController extends Controller
{
    public function new_country()
    {
        return view('country.new_country_form');
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'name'          =>       ['required','string','max:20'],
        ])->validate();

        // Add to Database
        Country::create([
            'name'            =>      $request->name,
        ]);

        return redirect()->route('dashboard')->with('message', 'Country Added Successfully')->with('message_type','good');
    }

    public function view_countries()
    {
        $countries = Country::with('cities')->get();

        return view('country.view_countries', compact('countries'));
    }

    public function delete_country(Request $request)
    {
        // delete Country

        Country::find($request->id)->delete();

        return redirect()->route('countries.view')->with('message', 'Country Deleted Successfully')->with('message_type','good');
    }

    public function edit_country($id)
    {
        $country = Country::find($id);

        return view('country.edit_country_form',compact('country'));
    }

    public function save_edit_country(Request $request)
    {
        global $country;
        $country = Country::find($request->id);
        
        // Validation 
        Validator::make($request->all(), [
            'name'          =>       ['required','string','max:20'],
        ])->validate();   

        // Updating
        $country->update([
            'name'            =>      $request->name,
        ]);

        return redirect()->route('countries.view')->with('message', 'Country Data Updated Successfully')->with('message_type','good');
    }


}
