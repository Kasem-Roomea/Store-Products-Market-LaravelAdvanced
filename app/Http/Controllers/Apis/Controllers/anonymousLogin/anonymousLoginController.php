<?php

namespace App\Http\Controllers\Apis\Controllers\anonymousLogin;

use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\users;
use App\Models\tokens;
use App\Http\Controllers\SoapController;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Str;

class anonymousLoginController extends index
{
    public static function api()
    {

        $request = self::$request;
        $record = users::createUpdate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
            'password' => $request->password,
            'image' => $request->image,
            'delivery_methods_id' => $request->deliveryMethodId,
            'model' => $request->model,
            'licenseNumber' => $request->licenseNumber,
            'driverLicenseImage' => $request->driverLicenseImage,
            'carLicenseImage' => $request->carLicenseImage,
            'IdPhoto' => $request->IdPhoto,
            'carImage' => $request->carImage,
            "balance" => 0,
            "fees" => 0,
            "cashback" => 0,
            "points" => 0,
            "isVerified" => 1,
        ]);
        $record->isVerified = 1;
        $record->save();


        tokens::create([
            'apiToken' => $record->apiToken,
            'users_id' => $record->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        return [
            'status' => 200,
            'message' => self::$messages['register']["200"],
            'Account' => objects::account($record)
        ];
    }
}
