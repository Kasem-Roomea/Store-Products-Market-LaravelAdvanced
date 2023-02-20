<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Controllers\index;
use Carbon\Carbon;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Support\Str;
use App\Models\locations;
class providers extends GeneralModel
{
    protected $table = 'providers',$appends=['type','img','location'];

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name =isset($params['name'])?$params['name']: $record->name;
        $record->phone =isset($params['phone'])?$params['phone']: $record->phone;
        $record->email =isset($params['email'])?$params['email']: $record->email;
        $record->isActive =isset($params['isActive'])?$params['isActive']: $record->isActive;
        $record->isVerified =isset($params['isVerified'])?$params['isVerified']: $record->isVerified;
        $record->firebaseToken =isset($params['firebaseToken'])?$params['firebaseToken']: $record->firebaseToken;
        $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'providers'): $record->image;
        $record->apiToken = isset($params['id'])?$record->apiToken: helper::UniqueRandomXChar(69,'apiToken');
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function sessions(){
        return $this->hasMany('\App\Models\sessions','providers_id');
    }
    function GetTypeAttribute(){
        return Str::singular($this->getTable());
    }
    function GetLocationAttribute(){
        return locations::where('providers_id',$this->id)->orderBy('id','DESC')->first();
    }
    function GetImgAttribute(){
        return request()->root().$this->image;
    }
}