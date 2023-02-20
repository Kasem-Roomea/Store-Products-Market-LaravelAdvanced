<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use Carbon\Carbon;

class contacts extends GeneralModel
{
    protected $table = 'contacts',$append=["sender"];

    public static function createUpdate($params)
    {
        
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->phone = isset($params["phone"])? $params["phone"]: $record->phone;
        $record->email = isset($params["email"])? $params["email"]: $record->email;
        $record->name = isset($params["name"])? $params["name"]: $record->name;
        $record->message = isset($params["message"])? $params["message"]: $record->message;
        $record->status = isset($params["status"])? $params["status"]: $record->status;
        $record->drivers_id = isset($params["drivers_id"])? $params["drivers_id"]: $record->drivers_id;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->code = isset($params["id"])? $record->code : helper::UniqueRandomXDigits(6,'code',['sessions']);
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function user()
    {
        return $this->belongsTo(users::class,"users_id");
    } 
    public function driver()
    {
        return $this->belongsTo(drivers::class,"drivers_id");
    } 
    public function store()
    {
        return $this->belongsTo(stores::class,"stores_id");
    } 
    function GetSenderAttribute(){
        if( $this->user)
            return $this->user;
        if( $this->driver)
            return $this->driver;
        if( $this->store)
            return $this->strore;
    }
}
