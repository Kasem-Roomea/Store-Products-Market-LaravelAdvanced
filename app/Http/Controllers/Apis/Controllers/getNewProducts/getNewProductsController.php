<?php

namespace App\Http\Controllers\Apis\Controllers\getNewProducts;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;

class getNewProductsController extends index
{
    public static function api()
    {
        $records =  products::orderBy("createdAt", "desc")
            ->where('isActive', 1)
            ->limit(self::$request->resultSize);
        return [
            "status" => $records->get()->count() ? 200 : 204,
            "totalResult" => $records->get()->count(),
            "products" => objects::ArrayOfObjects($records->get(), "product"),
        ];
    }
}
