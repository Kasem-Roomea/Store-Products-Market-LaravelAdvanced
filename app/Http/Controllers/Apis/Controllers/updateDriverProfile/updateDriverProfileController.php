<?php
namespace App\Http\Controllers\Apis\Controllers\updateDriverProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\drivers;
use App\Models\sessions;

class updateDriverProfileController extends index
{
    public static function api (){

        $request=self::$request;
        $record= drivers::createUpdate([
                    "id"=>self::$account->id,
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'language'=>$request->language,
                    'password'=>$request->password,
                    'image'=>$request->image,  
                    'delivery_methods_id'=>$request->deliveryMethodId,  
                    'model'=>$request->model,  
                    'licenseNumber'=>$request->licenseNumber,  
                    'driverLicenseImage'=>$request->driverLicenseImage,  
                    'carLicenseImage'=>$request->carLicenseImage,  
                    'IdPhoto'=>$request->IdPhoto,  
                    'carImage'=>$request->carImage,  
                ]);
        if(self::$request->phone){            
            $session= sessions::createUpdate([
                        $record->getTable()."_id" =>$record->id,
                        "tmpPhone"=>self::$request->phone,
                        'code'=>helper::RandomXDigits(5)
                    ]);
            helper::sendSMS($request->phone,$session->code);
        }
        return [
            'status'=>200,
            'message'=>self::$messages['register']["200"],
            'Account'=>objects::account( $record)
        ];
    }
}

