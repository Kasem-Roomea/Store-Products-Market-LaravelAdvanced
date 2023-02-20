<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use Carbon\Carbon;

class bills_details extends GeneralModel
{
    protected $table = 'bills_details',$appends=["image","createdAt",'created'];
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->cost = isset($params["cost"])? $params["cost"]: $record->cost;
        $record->bills_id = isset($params["bills_id"])? $params["bills_id"]: $record->bills_id;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'bills_details'): $record->image;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function bill(){
        return $this->belongsTo(bills::class,"bills_id");
    }
    function GetImageAttribute(){
        return isset ($this->attributes['image'] )? Request()->root().$this->attributes['image']:null;
    }
    function GetCreatedAttribute(){
       return  $this->attributes['createdAt'];
    }
    function GetCreatedAtAttribute(){
       return  Carbon::parse($this->attributes['createdAt'])->timestamp;
    }
}