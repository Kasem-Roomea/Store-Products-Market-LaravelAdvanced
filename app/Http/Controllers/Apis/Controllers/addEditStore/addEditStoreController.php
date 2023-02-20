<?php

namespace App\Http\Controllers\Apis\Controllers\addEditStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;
use App\Models\locations;
use App\Models\images_in_store;
use App\Models\phones;
use Illuminate\Support\Facades\File;
class addEditStoreController extends index
{
    public static function api(){

        $location= locations::createUpdate([
            'longitude'=>self::$request->location['longitude'],
            'latitude'=>self::$request->location['latitude'],
            'address'=>self::$request->location['address'],
            ]);
        $object =  [
            "logo"         =>self::$request->logo,
            'providers_id' =>self::$account->id,
            "name"         =>self::$request->name,
            "description"  =>self::$request->description,
            "categories_id"=>self::$request->categoryId,
            "locations_id" =>$location->id,
            "fromDay"      =>self::$request->fromDay,
            "toDay"        =>self::$request->toDay,
            "fromTime"     =>self::$request->fromTime,
            "toTime"       =>self::$request->toTime,
            "facebook"     =>self::$request->facebook,
            "twitter"      =>self::$request->twitter,
            "instagram"    =>self::$request->instagram,
            'is_active'    =>1
        ];
        if(self::$request->has('storeId')){
            $store=stores::find(self::$request->storeId);
            if($store->providers_id != self::$account->id )
                return ['status'=>403,'message'=>self::$messages["addEditStore"]["403"] ];
            $object['id']=$store->id;
            if(self::$request->has('images_in_store')){
                foreach ($store->images_in_store as $image) { 
                helper::deleteFile($image->link);
                    $image->delete();
                }
            }
            helper::deleteFile($store->logo);
            if(self::$request->has('phones')){
                phones::where('stores_id',$store->id)->delete();
            }
        }
        $record = stores::createUpdate($object);
        if(self::$request->has('images_in_store')){
            foreach(self::$request->images as $image)
                images_in_store::createUpdate([
                    'stores_id'=> $record->id,
                    'link'     =>$image
                ]);
        }
        if(self::$request->has('phones')){
            foreach(self::$request->phones as $phone)
                phones::createUpdate([
                    'phone'=> $phone,
                    'stores_id'=> $record->id,
                    'is_active'=> 1,
                ]);
        }
        return [
            "status"=>200,
            "store"=>objects::store($record),
        ];
    }
}