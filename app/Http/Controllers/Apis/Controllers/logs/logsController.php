<?php

namespace App\Http\Controllers\Apis\Controllers\logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\logs;

class logsController extends index
{
    public static function api(){

        $role=self::$account->user_role;
        $types=["chatMaster"];
        if(!in_array($role,$types))
            return ['status'=>403,'message'=> 'chatMaster'." انت لست "];

        $records=  logs::orderBy('id','DESC')->where('target_users_id',self::$account->id)->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "logs"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"log"),
        ];
                    

    }
}

