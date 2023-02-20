<?php

namespace App\Http\Controllers\Apis\Controllers\getProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;

class getProductsController extends index
{
    public static function api(){

        
        return [
            "status"=>200,
            "product"=>objects::product(products::find(self::$request->productId)),
        ];
    }
}