<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


class CategoryController extends Controller
{
    public function new_category()
    {
        return view('category.new_category_form');
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'category_name'     =>       ['required','max:20'],
        ])->validate();

        // Add to Database
        Category::create([
            'name' => $request->category_name,
            'description' => $request->description 
        ]);
        
        return redirect()->route('dashboard')->with('message', 'Category Added Successfully')->with('message_type','good');
    }

    public function view_categories()
    {
        $categories = Category::with('products')->get();

        // dd($categories);
        return view('category.view_categories', compact('categories'));
    }

    public function edit_category($id)
    {
        
        $category = Category::find($id);

        return view('category.edit_category_form',compact('category'));
    }

    public function save_edit_category(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'category_name'     =>       ['required','max:20'],
        ])->validate();
        
        // update database
        $category = Category::find($request->id);

        $category->update([
            'name' => $request->category_name,
            'description' => $request->description 
        ]);

        return redirect()->route('categories.view')->with('message', 'Category Data Updated Successfully')->with('message_type','good');
        
    }

    public function delete_category(Request $request)
    {
        // delete Category

        Category::find($request->id)->delete();

        return redirect()->route('categories.view')->with('message', 'Category Deleted Successfully')->with('message_type','good');
    }


}
