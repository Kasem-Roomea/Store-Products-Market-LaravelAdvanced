<?php
namespace App\Http\Controllers\Apis\Controllers\contactUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\contacts;

class contactUsController extends index
{
    public static function api() 
    {
        $table=  self::$account?self::$account->getTable()."_id":null;
        $record = contacts::createUpdate([
            'title'     =>self::$request->title,
            'message'   =>self::$request->message,
            'orders_id' =>self::$request->orderId,
            "email"     =>self::$request->email??self::$account->email?? null,
            'phone'     =>self::$request->phone??self::$account->phone?? null,
            $table      =>self::$account->id?? NULL,
            'status'    =>'open'
        ]);
        return [
            "status"=>200,
            "message"=>$record->code
        ];
    }
}