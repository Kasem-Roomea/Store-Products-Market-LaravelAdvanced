<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class offers_edited_price extends GeneralModel
{
    protected $table = 'offers_edited_price',$appends=["createdAt",'created'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->offers_id = isset($params["offers_id"])? $params["offers_id"]: $record->offers_id;
        $record->price = isset($params["price"])? $params["price"]: $record->price;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function offer(){
        return $this->belongsTo(offers::class,"offers_id");
    }
    function GetCreatedAttribute(){
       return  $this->attributes['createdAt'];
    }
    function GetCreatedAtAttribute(){
       return  Carbon::parse($this->attributes['createdAt'])->timestamp;
    }

}