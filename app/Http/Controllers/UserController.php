<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.new_user_form');
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'new_image'     =>       ['image','max:2048'],
            'first_name'    =>       ['required','string','max:50'],
            'last_name'     =>       ['required','string','max:50'],
            'email'         =>       ['required','email','max:50', 'unique:users'],
            'phone'         =>       ['required','numeric'],
            'gender'        =>       ['required'],
            'password'      =>       ['required','confirmed','min:8'] 
        ])->validate();

        // Save Image
        if ($request->new_image != null) {
            $req_image = $request->file('new_image');
    
            $image = rand().'.'.$req_image->getClientOriginalExtension();
    
            $req_image->move(public_path('images'), $image);
        
        } else {

            $image = 'default_vector.jpg';
        }


        // Add to Database
        $user = User::create([
            'first_name'            =>      $request->first_name,
            'last_name'             =>      $request->last_name,
            'email'                 =>      $request->email,
            'phone'                 =>      $request->phone,
            'gender'                =>      $request->gender,
            'group_id'              =>      $request->role,
            'password'              =>      HASH::make($request->password),
            'visit_number'          =>      '0',
            'profile_photo_url'     =>      'images/'.$image
        ]);

        return redirect()->route('dashboard')->with('message', 'User Added Successfully')->with('message_type','good');

    }

    public function view_users()
    {
        $users = User::all();

        return view('user.view_users', compact('users'));
    }

    public function view_user(Request $request)
    {
        $user = User::find($request->id);

        return response()->json(['user' => $user]);
    }

    public function edit_user($id)
    {
        
        $user = User::find($id);

        return view('user.edit_user_form',compact('user'));
    }

    public function save_edit_user(Request $request)
    {
        global $user;
        $user = User::find($request->id);
        
        // Validation 
        Validator::make($request->all(), [
            'new_image'     =>       ['nullable','image','max:2048'],
            'first_name'    =>       ['required','string','max:50'],
            'last_name'     =>       ['required','string','max:50'],
            'email'         =>       ['required','email','max:50', Rule::unique('users')->ignore($user->id)],
            'phone'         =>       ['required','numeric'],
            'gender'        =>       ['required'],
        ])->validate();   

        // Save Image
        if ($request->new_image != null) {
            $req_image = $request->file('new_image');

            $image = rand().'.'.$req_image->getClientOriginalExtension();

            $req_image->move(public_path('images'), $image);
        } else {
            $image = 'default_vector.jpg';
        }

        // Updating

        $user->update([
            'first_name'            =>       $request->first_name,
            'last_name'             =>       $request->last_name,
            'email'                 =>       $request->email,
            'phone'                 =>       $request->phone,
            'gender'                =>       $request->gender,
            'group_id'              =>       $request->role,
            'profile_photo_url'     =>       'images/'.$image
        ]);

        return redirect()->route('users.view')->with('message', 'User Data Updated Successfully')->with('message_type','good');
    }

    public function delete_photo(Request $request)
    {
        // delete profile photo

        User::find($request->id)->update(['profile_photo_url' => 'images/default_vector.jpg']);
        
        return response()->json(['success'=>'done']);
    }

    public function delete_user(Request $request)
    {
        // delete user

        User::find($request->id)->delete();

        return redirect()->route('users.view')->with('message', 'User Deleted Successfully')->with('message_type','good');
    }


}
