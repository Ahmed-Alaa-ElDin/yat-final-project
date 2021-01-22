<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function startApp()
    {
        $total_users = User::all();
        $total_users_num = count($total_users);
        global $total_visits_num;
        foreach ($total_users as $user) {
            $total_visits_num += $user->visit_number;
        }
        $total_orders_num = count(Order::get());
        $total_products_num = count(Product::get());

        return view('dashboard', compact('total_users_num','total_visits_num','total_orders_num','total_products_num'));
    }
}