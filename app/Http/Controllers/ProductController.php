<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
    public function new_product()
    {
        $categories = Category::all();

        return view('product.new_product_form', compact('categories'));
    }

    public function create(Request $request)
    {
        // Validation 
        Validator::make($request->all(), [
            'new_image'     =>       ['image','max:2048'],
            'name'          =>       ['required','string','max:50'],
            'price'         =>       ['required','numeric'],
            'quantity'      =>       ['required','numeric'],
            'category'      =>       ['required'] 
        ])->validate();

        // Save Image
        if ($request->new_image != null) {
            $req_image = $request->file('new_image');
    
            $image = rand().'.'.$req_image->getClientOriginalExtension();
    
            $req_image->move(public_path('images'), $image);
        
        } else {

            $image = 'default_vector_product.jpg';
        }

        // Add to Database
        Product::create([
            'name'            =>      $request->name,
            'description'     =>      $request->description,
            'price'           =>      $request->price,
            'quantity'        =>      $request->quantity,
            'category_id'     =>      $request->category,
            'photo_url'       =>      'images/'.$image
        ]);

        return redirect()->route('dashboard')->with('message', 'Product Added Successfully')->with('message_type','good');
    }

    public function view_products()
    {
        $products = Product::with("category")->get();

        return view('product.view_products', compact('products'));
    }

    public function view_product(Request $request)
    {
        $product = Product::with("category")->find($request->id);

        return response()->json(['product' => $product]);
    }

    public function delete_product(Request $request)
    {
        // delete product

        Product::find($request->id)->delete();

        return redirect()->route('products.view')->with('message', 'Product Deleted Successfully')->with('message_type','good');
    }

    public function edit_product($id)
    {
        
        $product = Product::with('category')->find($id);

        $categories = Category::all();

        return view('product.edit_product_form',compact('product','categories'));
    }

    public function save_edit_product(Request $request)
    {
        global $product;
        $product = Product::find($request->id);
        
        // Validation 
        Validator::make($request->all(), [
            'new_image'     =>       ['nullable','image','max:2048'],
            'name'          =>       ['required','string','max:50'],
            'price'         =>       ['required','numeric'],
            'quantity'      =>       ['required','numeric'],
            'category'      =>       ['required'] 
        ])->validate();   

        // Save Image
        if ($request->new_image != null) {
            $req_image = $request->file('new_image');

            $image = rand().'.'.$req_image->getClientOriginalExtension();

            $req_image->move(public_path('images'), $image);
        } else {
            $image = 'default_vector_product.jpg';
        }

        // Updating

        $product->update([
            'name'            =>      $request->name,
            'description'     =>      $request->description,
            'price'           =>      $request->price,
            'quantity'        =>      $request->quantity,
            'category_id'     =>      $request->category,
            'photo_url'       =>      'images/'.$image
        ]);

        return redirect()->route('products.view')->with('message', 'Product Data Updated Successfully')->with('message_type','good');
    }


    
    

}
