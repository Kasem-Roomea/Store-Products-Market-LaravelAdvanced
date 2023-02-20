<?php

namespace App\Http\Controllers\Apis\Controllers\updateProviderProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Models\sessions;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\providers;

class updateProviderProfileController extends index
{
    public static function api (){

        if(self::$account->getTable()!= 'providers')
            return [
                'status'=>422,
                'message'=>self::$messages['login']['422']
            ];
        $request=self::$request;
        sessions::whereIn('id',index::$account->sessions->pluck('id')->toArray())->delete();
        
        $record= providers::createUpdate([
                    'id'=>self::$account->id,
                    'name'=>$request->name,
                    'password'=>$request->password,
                    'image'=>$request->image,  
                ]);
        if(self::$request->has('image')){
            helper::deleteFile(self::$account->image);
        }
        if(self::$request->has('email') || self::$request->has('phone'))
            $session=sessions::createUpdate([
                $record->getTable().'_id' =>$record->id,
                'code'=>helper::RandomXDigits(5),
                "tmp_email"=>$request->email,
                "tmp_phone"=>$request->phone,
                "phone"=>$request->phone,
            ]);

        return [
            'account'=>objects::account( $record),
            'status'=>200,
            "message"=>self::$messages['updateProfile']["200"]
        ];
    } 
}