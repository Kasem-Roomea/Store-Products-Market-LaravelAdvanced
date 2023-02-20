<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class rooms extends GeneralModel
{
    protected $table = 'rooms',$appends=["latestMessage","hasUnseenMessages","countUnseen","createdAt",'created'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->colName = isset($params["colName"])? $params["colName"]: $record->colName;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'rooms'): $record->image;
        $record->deleted_at = isset($params["deleted_at"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updatedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
    public function provider(){
        return $this->belongsTo(users::class,"users_id");
    }
    function GetAnotherAttribute(){
        // return self::$account->type== 'user' ? $this->provider :$this->user;
    }
    function GetCreatedAttribute(){
       return  $this->attributes['createdAt'];
    }
    function GetCreatedAtAttribute(){
       return  Carbon::parse($this->attributes['createdAt'])->timestamp;
    }
    function GetlatestMessageAttribute(){
       return  messages::where("rooms_id",$this->id)->orderBy("id","desc")->first();
    }
    function GethasUnseenMessagesAttribute(){
       return  messages::where("rooms_id",$this->id)->orderBy("id","desc")->where("isSeen",0)->count()?true:false;
    }
    function GetCountUnseenAttribute(){
       return  messages::where("rooms_id",$this->id)->orderBy("id","desc")->where("isSeen",0)->count();
    }
}