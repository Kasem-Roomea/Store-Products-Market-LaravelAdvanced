<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class sessions extends GeneralModel
{
    protected $table = 'sessions';

    public static function createUpdate($params)
    {
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->tmpToken = isset($params['tmpToken']) ? $params['tmpToken']: $record->tmpToken;
        $record->tmpEmail = isset( $params['tmpEmail'])? $params['tmpEmail']: $record->tmpEmail;
        $record->tmpPhone = isset( $params['tmpPhone'])? $params['tmpPhone']: $record->tmpPhone;
        $record->users_id = isset( $params['users_id'])? $params['users_id']: $record->users_id;
        $record->drivers_id = isset( $params['drivers_id'])? $params['drivers_id']: $record->drivers_id;
        $record->stores_id = isset( $params['stores_id'])? $params['stores_id']: $record->stores_id;
        $record->code = isset($params["id"])? $record->code : helper::UniqueRandomXDigits(4,'code',['sessions']);
        // $record->code = isset($params["id"])? $record->code : 1234;
        $record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function users(){
        return $this->belongsTo(users::class,'users_id');
    }
    public function providers(){
        return $this->belongsTo(providers::class,'providers_id');
    }
}