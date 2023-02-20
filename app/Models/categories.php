<?php

namespace App\Models;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $table = 'categories',$guarded=[];
    public $timestamps=false;
   
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->orderNum = isset($params["orderNum"])? $params["orderNum"]: $record->orderNum;
        $record->nameAr = isset($params["nameAr"])? $params["nameAr"]: $record->nameAr;
        $record->nameEn = isset($params["nameEn"])? $params["nameEn"]: $record->nameEn;
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->categories_id = isset($params["categories_id"])? $params["categories_id"]: $record->categories_id;
        $record->start_at_offer = isset($params["start_at_offer"])? $params["start_at_offer"]: $record->start_at_offer;
        $record->end_at_offer = isset($params["end_at_offer"])? $params["end_at_offer"]: $record->end_at_offer;
        $record->discount = isset($params["discount"])? $params["discount"]: $record->discount;
        $record->image =isset($params['image'])?helper::base64_image_dash( $params['image'],'users'): $record->image;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    function Categorie_perant(){
        return $this->belongsTo('App\Models\categories' , 'categories_id' , 'id' );
    }
    public function category(){
        return $this->belongsTo(categories::class,'categories_id');
    }
    public function store(){
        return $this->belongsTo(stores::class,'stores_id');
    }

}
