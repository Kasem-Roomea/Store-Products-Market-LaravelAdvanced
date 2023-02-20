<?php
namespace App\Http\Controllers\Apis\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use DB;
use Illuminate\Support\Str;

class reportsController extends index
{
    public static function api()
    {
        $orders= orders::all()->where(self::$account->getTable()."_id", self::$account->id);
        $noOfOrders= $orders->count();
        $OrdersBerThisMonth= orders::whereMonth('createdAt', date("m"))
                                   ->get()
                                   ->where(self::$account->getTable()."_id", self::$account->id);
        $noOfOrdersBerThisMonth= $OrdersBerThisMonth->count();
        
        $response =  [
            "status"=> 200,
            "report"=>[
                "points" => self::$account->points,
                "balance" => self::$account->balance,
                "totalOrder" =>[
                    "noOfOrder"=>$noOfOrders,
                    'deliveryPrice'=>$orders->sum('deliveryPrice'),
                    "products_price"=>$orders->sum("products_price"),
                    "fees"=>$orders->sum(Str::camel(Str::singular(self::$account->getTable())."_fees"))
                ],
                "ordersBerThisMonth"=>[
                    "noOfOrder"=>$noOfOrdersBerThisMonth,
                    'deliveryPrice'=>$OrdersBerThisMonth->sum('deliveryPrice'),
                    "products_price"=>$OrdersBerThisMonth->sum("products_price"),
                    "fees"=>$OrdersBerThisMonth->sum(Str::camel(Str::singular(self::$account->getTable())."_fees"))
                ],
            ]
        ];
        if(self::$request->isMethod("get")){
            dd($response);
        }else{
            return $response;
        }
        
    }
}