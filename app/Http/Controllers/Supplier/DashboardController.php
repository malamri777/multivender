<?php

namespace App\Http\Controllers\Supplier;

use App\Models\Order;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data['products'] = filter_products(Product::where('user_id', Auth::user()->id)->whereHas('warehouseProducts',function($q){
            $q->where('published', 1)->orderBy('num_of_sale', 'desc');
        }))->limit(12)->get();
        $data['last_7_days_sales'] = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('seller_id', '=', Auth::user()->id)
            ->where('delivery_status', '=', 'delivered')
            ->select(DB::raw("sum(grand_total) as total, created_at as date"))
            ->groupBy("created_at")
            ->get()->pluck('total', 'date');

        // $data['last_7_days_sales'] = Order::where('created_at', '>=', Carbon::now()->subDays(7))
        //                         ->where('seller_id', '=', Auth::user()->id)
        //                         ->where('delivery_status', '=', 'delivered')
        //                         ->select(DB::raw("sum(grand_total) as total, DATE_FORMAT(created_at, '%d %b') as date"))
        //                         ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
        //                         ->get()->pluck('total', 'date');

        return view('supplier.dashboard', $data);
    }
}
