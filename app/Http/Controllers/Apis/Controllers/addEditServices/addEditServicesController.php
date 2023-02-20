<?php
namespace App\Http\Controllers\Apis\Controllers\addEditServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;
use App\Models\services_in_store;

class addEditServicesController extends index
{
    public static function api()
    {
        $store= stores::find(self::$request->storeId);
        if(!$store->is_active)
            return ['status'=>403 ,'message'=>self::$messages["stores"]["403"] ];
        if($store->providers_id != self::$account->id )
            return ['status'=>403 ,'message'=>self::$messages["stores"]["403"] ];
        foreach(self::$request->services as $service){
            services_in_store::where('stores_id',$store->id)
                             ->where("services_id",$service['id']) 
                             ->delete();
            services_in_store::createUpdate([
                'stores_id'=>$store->id,
                'services_id'=>$service['id'],
                'price'=>$service['price'],
                'discount'=>$service['discount']
            ]);
        }
        return [
            "status"=>200,
        ];
    }
}