<?php
namespace App\Http\Controllers\Apis\Controllers\productClick;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;
use App\Models\view_products;

class productClickController extends index
{
    public static function api(){

        if(view_products::count() ){
            $message= "seen before";
        }else{
            $record=  products::createUpdate([
                "id"=>self::$request->productId,
                "viewers"=>products::find(self::$request->productId)->viewers+=1 
            ]);
            view_products::createUpdate([
                "products_id"=>self::$request->productId,
                "device_id"=>self::$request->device_id,
            ]);
            $message= "first seen ";

        }
        
        return [
            "status"=>200,
            'message'=>$message
        ];
    }
}