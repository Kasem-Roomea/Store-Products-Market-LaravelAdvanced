<?php

namespace App\Http\Controllers\Apis\Controllers\getUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users_in_general_rooms;
use App\Models\users_in_private_rooms;
use App\Models\users;

class getUsersController extends index
{
    public static function api(){

        $records=  users::allActive()->where('is_verified',1);
        
        if(self::$request->has('privateRoomId') ||  self::$request->has('generalRoomId') ){
            $relation= self::$request->has('privateRoomId') ? 'users_in_private_rooms':'users_in_general_rooms' ;
            $modelName= self::$request->privateRoomId? 'private_rooms':'general_rooms'; 
            $colId= self::$request->privateRoomId? self::$request->privateRoomId:self::$request->generalRoomId; 
        
            $model='\App\Models\\'.$modelName;
            $room=$model::findActive($colId);
            if(!$room)
                return ['message'=>"هذه الغرفة غير متوفرةالان"];

            $ids= $room->$relation->pluck('users_id')->toArray();
            $records=$records->whereIn('id',$ids);
        }

        if(self::$request->has('name') ) {
            $search=self::$request->name;
            $records = $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
        }
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "users"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"user"),
        ];
    }
}