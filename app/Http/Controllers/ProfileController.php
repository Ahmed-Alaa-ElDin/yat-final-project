<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function upload_photo(Request $request)
    {
        // validation 

        Validator::make($request->all(), [
            'new_image' => ['required','image','max:2048'],
        ])->validate();
        
        // Save Image
        
        $req_image = $request->file('new_image');

        $image = rand().'.'.$req_image->getClientOriginalExtension();

        $req_image->move(public_path('images'), $image);

        // update database

        Auth::user()->update(['profile_photo_url' => 'images/'.$image]);
        
        return response()->json(['success'=>'done','image'=>$image]);
    }

    public function delete_photo(Request $request)
    {
        Auth::user()->update(['profile_photo_url' => 'images/default_vector.jpg']);
        
        return response()->json(['success'=>'done']);
    }

    public function update(Request $request)
    {
        global $user;
        $user = Auth::user();

        Validator::make($request->all(), [
            'first_name'        =>      ['required','string','max:50'],
            'last_name'         =>      ['required','string','max:50'],
            'email'             =>      ['required','email','max:50', Rule::unique('users')->ignore($user->id),],
            'phone'             =>      ['required','numeric'],
            'gender'            =>      ['required'],
            'current_password'  =>      ['required', 
            function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Your data was not updated, since the provided current password does not match.');
                    }
            }]
        ])->validate();

        $user->update([
            'first_name'    =>       $request->first_name,
            'last_name'     =>       $request->last_name,
            'email'         =>       $request->email,
            'phone'         =>       $request->phone,
            'gender'        =>       $request->gender,
        ]);
        
        if ($request->password != null) {
            Validator::make($request->all(), [
                'password' => ['confirmed','min:8','different:current_password'],
                ])->validate();

            if ($request->current_password != $request->password) {
                $user->update([
                    'password' => HASH::make($request->password),
                ]);
                // dd($request->password);
            }
        }
        
        return redirect()->route('dashboard')->with('message', 'Profile Data Updated Successfully')->with('message_type','good');
    }

}
