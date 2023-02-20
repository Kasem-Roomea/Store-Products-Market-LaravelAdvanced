<?php

namespace App\Http\Controllers\Apis\Controllers\getMessages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\messages;
use App\Models\rooms;
use App\Models\users;
use App\Models\providers;

class getMessagesController extends index
{
    public static function api(){

        $another= self::$account->type== 'user'?'providers_id':'users_id';
        $table= self::$account->type== 'user'?providers::class:users::class;
        if(!$table::find(self::$request->targetId)){
            return [
                'status'=>405,
                "message"=>'error in targetId'
            ];
        }
        $room=    rooms::where(self::$account->type."s_id",self::$account->id)
                        ->where($another,self::$request->targetId)
                        ->first();
        $records=  messages::where('rooms_id',$room->id)->orderBy("id","DESC")->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "messages"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}