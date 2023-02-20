<?php

namespace App\Http\Controllers\Apis\Controllers\notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\notify;

class notificationsController extends index
{
    public static function api(){

        $records=  notify::orderBy('id','DESC')->where(self::$account->getTable().'_id',self::$account->id)->get();
        foreach($records->forPage(self::$request->page+1,self::$itemPerPage) as $record)
           notify::createUpdate([
                'id'=>$record->id,
                'isSeen'=>1
            ]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "notifications"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"notification"),
        ];
                    

    }
}

