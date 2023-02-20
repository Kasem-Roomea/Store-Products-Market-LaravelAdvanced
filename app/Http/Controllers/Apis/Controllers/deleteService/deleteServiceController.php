<?php
namespace App\Http\Controllers\Apis\Controllers\deleteService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\services_in_store;
use App\Models\stores;

class deleteServiceController extends index
{
    public static function api()
    {
        $record=  services_in_store::where('services_id',self::$request->serviceId)
                                   ->whereIn('stores_id',stores::where('providers_id',self::$account->id)->pluck('id'))
                                   ->first();
        if(!$record || $record->stores->providers_id != self::$account->id){
            return [
                'status'=>403,
                "message"=>self::$messages["deleteService"]["403"]
            ];
        }
        $record->delete();
        return [
            "status"=>200,
        ];
    }
}