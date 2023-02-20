<?php

namespace App\Models;
use App\Http\Controllers\Apis\Helper\helper ;

use Illuminate\Database\Eloquent\Model;

class order_images extends GeneralModel
{
    protected $table = 'order_images',$appends=['image'];

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'order_images'): $record->image;
        $record->createdAt = isset($params["createdAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    function GetImageAttribute(){
        return Request()->root().$this->attributes['image'];
    }

}