<?php
namespace App\Models;

use App\Models\friends;
use App\Models\followers;
use App\Models\roles;
use App\Models\verified_request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\Apis\Controllers\index;
use Carbon\Carbon;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Support\Str;
use App\Models\locations;

class drivers extends Model
{
    protected $table = 'drivers',$appends=['type',"rate",'session'],$with=['vehicle',"delivery_method"];
    protected $guarded = [];
    public $timestamps = false;
    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name =isset($params['name'])?$params['name']: $record->name;
        $record->language =isset($params['language'])?$params['language']: $record->language;
        $record->phone =isset($params['phone'])?$params['phone']: $record->phone;
        $record->balance =isset($params['balance'])?$params['balance']: $record->balance;
        $record->fees =isset($params['fees'])?$params['fees']: $record->fees;
        $record->email =isset($params['email'])?$params['email']: $record->email;
        $record->firebaseToken =isset($params['firebaseToken'])?$params['firebaseToken']: $record->firebaseToken;
        $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
        $record->apiToken = isset($params['id'])?$record->apiToken: helper::UniqueRandomXChar(69,'apiToken');
        $record->vehicles_id =isset($params['vehicles_id'])?$params['vehicles_id']: $record->vehicles_id;
        $record->delivery_methods_id =isset($params['delivery_methods_id'])?$params['delivery_methods_id']: $record->delivery_methods_id;
        $record->delivery_methods_id =isset($params['deliveryMethodId'])?$params['deliveryMethodId']: $record->delivery_methods_id;
        $record->model =isset($params['model'])?$params['model']: $record->model;
        $record->licenseNumber =isset($params['licenseNumber'])?$params['licenseNumber']: $record->licenseNumber    ;

        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'drivers'): $record->image;
        $record->carLicenseImage =isset($params['carLicenseImage'])?helper::base64_image( $params['carLicenseImage'],'drivers'): $record->carLicenseImage;
        $record->driverLicenseImage =isset($params['driverLicenseImage'])?helper::base64_image( $params['driverLicenseImage'],'drivers'): $record->driverLicenseImage;
        $record->IdPhoto =isset($params['IdPhoto'])?helper::base64_image( $params['IdPhoto'],'drivers'): $record->IdPhoto;
        $record->carImage =isset($params['carImage'])?helper::base64_image( $params['carImage'],'drivers'): $record->carImage;

        $record->image =isset($params['imageDash'])?helper::uploadPhoto( $params['imageDash'],'drivers'): $record->image;
        $record->carLicenseImage =isset($params['carLicenseImageDash'])?helper::uploadPhoto( $params['carLicenseImageDash'],'drivers'): $record->carLicenseImage;
        $record->driverLicenseImage =isset($params['driverLicenseImageDash'])?helper::uploadPhoto( $params['driverLicenseImageDash'],'drivers'): $record->driverLicenseImage;
        $record->IdPhoto =isset($params['IdPhotoDash'])?helper::uploadPhoto( $params['IdPhotoDash'],'drivers'): $record->IdPhoto;
        $record->carImage =isset($params['carImageDash'])?helper::uploadPhoto( $params['carImageDash'],'drivers'): $record->carImage;

        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    public function nameCarDrivers()
    {
        return $this->belongsTo('App\Models\vehicles','vehicles_id' , 'id');
    }

    public function nameDeleveryDrivers()
    {
        return $this->belongsTo('App\Models\delivery_methods','delivery_methods_id' , 'id');
    }
    public function vehicle(){
        return $this->belongsTo(vehicles::class,'vehicles_id');
    }
    public function delivery_method(){
        return $this->belongsTo(delivery_methods::class,'delivery_methods_id');
    }
    public function sessions(){
        return $this->hasMany('\App\Models\sessions','drivers_id');
    }
    function GetSessionAttribute(){
        return $this->sessions->first()??null;
    }

    function GetTypeAttribute(){
        return $this->isDriver?"driver":"user";
    }
    public function reviews(){
        return $this->hasMany(reviews::class,'drivers_id');
    }
    function GetRateAttribute(){
        return (double)($this->reviews?$this->reviews->where("type","!=","driverToUser")->avg('rate'):0);
    }

    // function GetRateAttribute(){
    //     if($this->isDriver){
    //         return reviews::where('drivers_id',$this->id)
    //                       ->where("type","userToDriver")
    //                       ->avg("rate");
    //     }else{
    //         return reviews::where('drivers_id',$this->id)
    //                       ->where("type","driverToUser")
    //                       ->avg("rate");
    //     }
    // }
    function driver_cancel_orders()
    {
        return $this->hasOne(driver_cancel_orders::class,'drivers_id');
    }
}