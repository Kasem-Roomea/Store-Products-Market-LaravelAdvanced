<?php
namespace App\Http\Controllers\Apis\Controllers\getAds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ads;

class getAdsController extends index
{
    public static function api()
    {
        $screen=["offer"=>"offer","category"=>"categories","product"=>"products","welcome"=>"welcome"];
        $records=  ads::allActiveOnly()
                      ->where("screen",$screen[self::$request->type])
                      ->where("products_id",$request->productId)    
                      ->where("stores_id",$request->storeId)    
                      ->where('end_date','>',date("Y-m-d"))
                      ->where('start_date','<=',date("Y-m-d"));

        return [
            'status'=>$records->count()?200:204,
            'ads'=>objects::ArrayOfObjects($records->forPage(0,20) ,'ad'),
        ];
    }
}