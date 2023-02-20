<?php
namespace App\Http\Controllers\Apis\Controllers\setLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\locations;
use App\Models\orders;

class setLocationController extends index
{
    public static function api()
    {
        // locations::where(self::$account->getTable()."_id",self::$account->id)->delete();
        $lastLocations = locations::where(self::$account->getTable()."_id",self::$account->id)
                                 ->get();
      
        foreach($lastLocations as $lastLocation){
          
            $lon1=$lastLocation->longitude;
            $lat1=$lastLocation->latitude;
            $lon2=self::$request->location["longitude"];
            $lat2=self::$request->location["latitude"];
            
    		$theta = $lon1 - $lon2;
    		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    		$dist = acos($dist);
    		$dist = rad2deg($dist);
    		$miles = $dist * 60 * 1.1515;
    		$km= ($miles * 1.609344);
    		if($km < 0.05){
    		    $lastLocation->delete();   
    		}
    	}

        $record=  locations::createUpdate([
            'longitude'=>self::$request->location["longitude"],
            'latitude'=>self::$request->location["latitude"],
            'address'=>self::$request->location["address"],
            self::$account->getTable()."_id"=>self::$account->id
        ]);
        if(self::$request->has("orderId")){
            $order= orders::find(self::$request->orderId);
            helper::SocketUser($order->users_id,'updateLocationOfDriver',objects::location($record));
            helper::SocketStore($order->stores_id,'updateLocationOfDriver',objects::location($record));
        }
        return [
            "status"=>200,
            'location'=>objects::location($record)
        ];
    }
}