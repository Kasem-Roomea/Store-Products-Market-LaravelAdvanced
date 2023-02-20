<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class recharges extends GeneralModel
{
    protected $table = 'recharges';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->amount = isset($params["amount"])? $params["amount"]: $record->amount;
        $record->status = isset($params["status"])? $params["status"]: $record->status;
        $record->code = isset($params["id"])? $record->code : helper::UniqueRandomXChar(5,'code',['recharges']);
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->providers_id = isset($params["providers_id"])? $params["providers_id"]: $record->providers_id;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'recharges'): $record->image;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function provider(){
        return $this->belongsTo("\App\Models\providers","providers_id");
    }
    public function user(){
        return $this->belongsTo("\App\Models\users","users_id");
    }
}