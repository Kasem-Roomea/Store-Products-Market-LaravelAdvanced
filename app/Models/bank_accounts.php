<?php
namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class bank_accounts extends GeneralModel
{
    protected $table = 'bank_accounts' , $appends=['bankName','ownerName','img'];

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->colName = isset($params["colName"])? $params["colName"]: $record->colName;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'bank_accounts'): $record->image;
        $record->deleted_at = isset($params["deleted_at"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updated_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function ModelName1(){
        return $this->belongsTo("\App\Models\ModelName1","ModelName1_id");
    }
    public function ModelName2(){
        return $this->hasMany("\App\Models\ModelName2",'bank_accounts_id');
    }
    function GetOwnerNameAttribute(){
        $ownerName = 'ownerName'.self::$lang;
        return $this->$ownerName;
    }
    function GetBankNameAttribute(){
        $bankName = 'bankName'.self::$lang;
        return $this->$bankName;
    }
    function GetImgAttribute(){
        return Str::contains($this->image,["http","www"])? $this->image : request()->root().$this->image;
    }
}