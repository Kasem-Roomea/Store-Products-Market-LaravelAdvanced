<?php

namespace App\Http\Controllers\Apis\Controllers\register;

use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\users;
use App\Http\Controllers\SoapController;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Str;

class registerController extends index
{
    public static function api()
    {

        $request = self::$request;
        $type = "App\Models\\" . self::$request->type . "s";
        $record = $type::createUpdate([
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
            "points" => 0
        ]);
        if (self::$request->phone) {
            $session = sessions::createUpdate([
                $record->getTable() . "_id" => $record->id,
                'code' => helper::RandomXDigits(4)
            ]);
            error_log("Send message");
            error_log($request->phone);
            error_log($session->code);
            helper::sendSMS($request->phone, $session->code);
        }
        return [
            'status' => 200,
            'message' => self::$messages['register']["200"],
            'Account' => objects::account($record)
        ];
    }
}
