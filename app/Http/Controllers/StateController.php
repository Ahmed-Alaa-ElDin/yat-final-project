<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Models\State;

class StateController extends Controller
{
    public function new_state()
    {
        $cities = City::all();

        return view('state.new_state_form', compact('cities'));
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'name'      =>    ['required','string','max:20'],
            'city'      =>    ['required'],
        ])->validate();

        // Add to Dacititabase
        State::create([
            'name'      =>   $request->name,
            'city_id'   =>   $request->city,
        ]);

        return redirect()->route('dashboard')->with('message', 'State Added Successfully')->with('message_type','good');
    }

    public function view_states()
    {
        $states = State::with('city')->get();

        return view('state.view_states', compact('states'));
    }

    public function delete_state(Request $request)
    {
        // delete State

        State::find($request->id)->delete();

        return redirect()->route('states.view')->with('message', 'State Deleted Successfully')->with('message_type','good');
    }

    public function edit_state($id)
    {
        $state = State::with('city')->find($id);

        $cities = City::all();

        return view('state.edit_state_form',compact('state','cities'));
    }

    public function save_edit_state(Request $request)
    {
        global $state;
        $state = State::find($request->id);
        
        // Validation 
        Validator::make($request->all(), [
            'name'          =>       ['required','string','max:20'],
            'city'       =>       ['required'],
        ])->validate();   

        // Updating
        $state->update([
            'name'            =>      $request->name,
            'city_id'      =>      $request->city,
        ]);

        return redirect()->route('states.view')->with('message', 'State Data Updated Successfully')->with('message_type','good');
    }

}
