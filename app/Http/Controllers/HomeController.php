<?php

namespace App\Http\Controllers;

use App\Models\drivers;
use App\Models\orders;
use App\Models\stores;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }




    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function index()
    {
        // return admins::all();
        $users = json_encode(self::Query('users'));
        $drivers = json_encode(self::Query('drivers'));
        $orders = json_encode(self::Query('orders'));
        $stores = json_encode(self::Query('stores'));
        $usersCount=user::count();
        $driversCount=driver::count();
        $ordersCount=order::count();
        $storesCount=store::count();
        return view('index', compact('users','drivers','stores','orders','usersCount','driversCount','ordersCount','storesCount'));
    }

    private  static function Query($tableNAme)
    {
        return DB::table($tableNAme)
            ->select(
                DB::raw('COUNT(id) as `value`'),
                DB::raw("MONTH(createdAt) as `month`")
            )
            ->where(DB::raw("YEAR(createdAt)"), '=', date('Y'))
            ->groupBy('month')
            ->get();
    }
}
