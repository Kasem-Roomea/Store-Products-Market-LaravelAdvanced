<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class images extends Model
{
    protected $table = 'images';
    public $timestamps=false,$guarded=[];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->image = isset($params["image"])?helper::uploadPhoto( $params["image"],'images'): $record->image;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updatedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
}