<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class brands extends Model
{
    protected $table = 'brands' , $appends=['img'] ;
    public $timestamps=false,$guarded=[];


    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->colName = isset($params["colName"])? $params["colName"]: $record->colName;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'brands'): $record->image;
        $record->deleted_at = isset($params["deleted_at"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updated_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
   
    function GetImgAttribute(){
        return Str::contains($this->image,["http","www"])? $this->image : request()->root().$this->image;
    }
}