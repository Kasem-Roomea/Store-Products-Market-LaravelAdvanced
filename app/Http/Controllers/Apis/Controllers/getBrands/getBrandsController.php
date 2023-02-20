<?php
namespace App\Http\Controllers\Apis\Controllers\getBrands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\brandResource;
use App\Models\brands;
use App\Models\categories;
use App\Models\products;

class getBrandsController extends index
{
    public static function api()
    {
        $records=  brands::when(self::$request->subCategoryId,function($q){
                    $brandsIds=products::where('categories_id',self::$request->subCategoryId)
                                    ->pluck('brands_id')
                                    ->toArray();
                        return $q->whereIn('id',$brandsIds);
                    })
                    ->forPage(self::$request->page+1,self::$itemPerPage);
        $total= $records->count();
        $records= $records->get();
        return [
            "status"=>$records->count()?200:204,
            "totalPages"=>ceil($total/self::$itemPerPage),
            "brands"=>brandResource::brands($records),
        ];
    }
}