<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class StatController extends Controller
{
    public function go_to_stat()
    {
        $top = User::orderBy('visit_number','DESC')->take(10)->get();
        $stats = User::select(DB::raw('DATE(`created_at`) As date'),DB::raw('COUNT(DATE(`created_at`)) AS number'))->groupBy(DB::raw('DATE(`created_at`)'))->distinct(DB::raw('DATE(`created_at`)'))->get();
    
        return view('statistic.index', compact('stats','top'));
    }    
}
