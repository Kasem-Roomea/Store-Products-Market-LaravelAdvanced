<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Apis\Controllers\index;

class GeneralModel extends Model
{
    public $timestamps=false;
    public static  $account,$lang;
    function __construct(){
        self::$account=index::$account;
        self::$lang=index::$lang??'Ar';
    }
    public static function allNoTrashed(){
        return self::where('deletedAt',null)->get();
    }
    public static function findNoTrashed($id){
        $record = self::find($id);
        if($record==null )
            return null;
        else
            return $record->deletedAt == null ? $record : null ;
    }
    public static function allActive(){
        
        return self::orderBy('id','DESC')->where('isActive',1)->get()->where('deletedAt',null);
    }
    public static function allActiveOnly(){
        
        return self::orderBy('id','DESC')->where('isActive',1)->get();
    }
    public static function findActive($id){
        
        return self::where('id',$id)->where('isActive',1)->first()->where('deletedAt',null);
    }
    public static function findAllActive($id){
        
        return self::whereIn('id',$id)->where('isActive',1)->get()->where('deletedAt',null);
    }
    function GetImgAttribute(){
        return request()->root().$this->image;
    }
}
