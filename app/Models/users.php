<?php
namespace App\Models;

use Carbon\Carbon;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Models\locations;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = 'users',$appends=['type','location',"rate",'session'],$guarded=[];
    public $timestamps = true;

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name =isset($params['name'])?$params['name']: $record->name;
        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'users'): $record->image;
        $record->image =isset($params['imag'])?helper::base64_image_dash( $params['imag'],'users'): $record->image;
        $record->apiToken = isset($params['id'])?$record->apiToken: helper::UniqueRandomXChar(69,'apiToken');
        $record->social_token =isset($params['social_token'])?$params['social_token']: $record->social_token;
        $record->phone =isset($params['phone'])?$params['phone']: $record->phone;
        $record->email =isset($params['email'])?$params['email']: $record->email;
        $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
        $record->firebaseToken =isset($params['firebaseToken'])?$params['firebaseToken']: $record->firebaseToken;
        $record->language =isset($params['language'])?$params['language']: $record->language;
        $record->isOnline =isset($params['isOnline'])?$params['isOnline']: $record->isOnline;
        $record->points =isset($params['points'])?$params['points']: $record->points;
        $record->balance =isset($params['balance'])?$params['balance']: $record->balance;
        $record->fees =isset($params['fees'])?$params['fees']: $record->fees;
        $record->cashback =isset($params['cashback'])?$params['cashback']: $record->cashback;
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function vehicle(){
        return $this->belongsTo(vehicles::class,'vehicles_id');
    }
    public function delivery_method(){
        return $this->belongsTo(delivery_methods::class,'delivery_methods_id');
    }
    public function sessions(){
        return $this->hasMany('\App\Models\sessions','users_id');
    }
    public function reviews(){
        return $this->hasMany(reviews::class,'users_id');
    }
    function GetRateAttribute(){
        return (double) ($this->reviews?$this->reviews->where("type","driverToUser")->avg('rate'):0);
    }

    function GetSessionAttribute(){
        return $this->sessions->first()??null;
    }
    function GetTypeAttribute(){
        return $this->isDriver?"driver":"user";
    }

    function GetLocationAttribute(){
        return
                locations::where('users_id',$this->id)
                         ->orderBy("id","DESC")
                         ->first();
    }
    // function GetRateAttribute(){
    //     if($this->isDriver){
    //         return reviews::where('drivers_id',$this->id)
    //                       ->where("type","userToDriver")
    //                       ->avg("rate");
    //     }else{
    //         return reviews::where('users_id',$this->id)
    //                       ->where("type","driverToUser")
    //                       ->avg("rate");
    //     }
    // }
}