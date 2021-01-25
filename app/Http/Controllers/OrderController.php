<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Address;
use App\Models\Product;
use App\Models\Item;


class OrderController extends Controller
{
    // get Users & Countries
    public function new_order()
    {
        $users = User::with('addresses')->get();
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();

        return view('order.new_order_form' , compact('users','countries'));
    }

    // get old addresses
    public function get_address(Request $request)
    {
        $addresses = User::with('addresses')->find($request->user_id);
        
        $all_addresses = [];
        foreach ($addresses->addresses as $address) {
            $country = Country::find($address->country_id);
            $city = City::find($address->city_id);
            $state = State::find($address->state_id);
            $one_address = $state->name .", ". $city->name .", ". $country->name;
            $all_addresses[$address->id] = $one_address;
        }

        return response()->json(['addresses' => $all_addresses]);
    }

    // get country's cities
    public function get_cities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();

        return response()->json(['cities' => $cities]);
    }

    // get city's states
    public function get_states(Request $request)
    {
        $states = State::where('city_id', $request->city_id)->get();

        return response()->json(['states' => $states]);
    }

    // Save the new Address & Empty Order
    public function save_address_order(Request $request)
    {
        if ($request->address == 0) {
            $address = Address::create([
                'user_id'       =>    $request->user,
                'country_id'    =>    $request->country,
                'city_id'       =>    $request->city,
                'state_id'      =>    $request->state
            ]);
            $order = Order::create([
                'user_id'       =>   $request->user,
                'address_id'    =>   $address->id
            ]);
            
            $order_id = $order->id; 

        } elseif ($request->address > 0) {

            $order = Order::create([
                'user_id'       =>   $request->user,
                'address_id'    =>   $request->address
            ]);

            $order_id = $order->id; 

        }

        $products = Product::all(); 
        return view('order.add_items', compact('order_id', 'products'));
    }

    public function save_item(Request $request)
    {
        $Item = Item::create([
            'product_id'    =>      $request->product_id,
            'order_id'      =>      $request->order_id,
            'price'         =>      $request->price,
            'quantity'      =>      $request->quantity,
            'total'         =>      $request->total
        ]);

        return response()->json(['item_id' => $Item->id]);
    }
    
    public function delete_item(Request $request)
    {
        Item::find($request->item_id)->delete();

        return response()->json(['message' => 'Success']);
    }
    
    public function delete_order(Request $request)
    {
        Order::find($request->order_id)->delete();

        return response()->json(['message' => 'Success']);
    }

    public function delete_one_order(Request $request)
    {
        Order::find($request->order_id)->delete();

        return $this->view_orders();

    }

    public function save_order(Request $request)
    {
        Order::find($request->order_id)->update([
            'total_price'     =>      $request->total,
            'status'          =>      '1'
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function view_orders()
    {
        $orders = Order::with('user')->with('address')->with('items')->get();
        $addresses = Address::with('country')->with('city')->with('state')->get();
        
        return view('order.view_orders', compact('orders','addresses'));
    }

    public function view_order(Request $request)
    {

        $order = Order::with('user')->with('address')->with('items')->find($request->id);

        $address = Address::with('country')->with('city')->with('state')->find($order->address_id);
        
        $items = [];

        foreach ($order->items as $item) {
            $item_details = Item::with('product')->find($item->id);
            $my_item = [
                'product' => $item_details->product->name,
                'unit_price' => $item_details->price,
                'quantity' => $item_details->quantity,
                'total_price' => $item_details->total
            ];
            array_push($items,$my_item);
        }

        return response()->json(['order' => $order, 'address' => $address, 'items' => $items]);
    }
}
