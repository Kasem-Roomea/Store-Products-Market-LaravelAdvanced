<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\locations;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;

class stores extends Authenticatable
{
    protected $table = 'stores',
    $appends=['location','session',"distance","rate","has_offer",'regions'];

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) : new self();
        // dd($record);
        $record->name = isset($params["name"])? $params["name"]: $record->name;
        $record->phone =isset($params['phone'])?$params['phone']: $record->phone;
        $record->email =isset($params['email'])?$params['email']: $record->email;
        $record->fees =isset($params['fees'])?$params['fees']: $record->fees;
        $record->balance =isset($params['balance'])?$params['balance']: $record->balance;
        $record->firebaseToken =isset($params['firebaseToken'])?$params['firebaseToken']: $record->firebaseToken;
        $record->categories_id =isset($params['categories_id'])?$params['categories_id']: $record->categories_id;
        $record->deliveryTime =isset($params['deliveryTime'])?$params['deliveryTime']: $record->deliveryTime;
        $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
        $record->discount =isset($params['discount'])?$params['discount']: $record->discount;
        // if( isset($params["discount"]) &&  !$record->discountCode ){
            $record->discountCode =isset($params['discountCode'])?$params['discountCode']: $record->discountCode;
            $record->start_at_offer =isset($params['start_at_offer'])?$params['start_at_offer']: $record->start_at_offer;
            $record->end_at_offer =isset($params['end_at_offer'])?$params['end_at_offer']: $record->end_at_offer;
        // }
        $record->image =isset($params['image'])?helper::base64_image_dash( $params['image'],'users'): $record->image;
        $record->apiToken = isset($params['id'])?$record->apiToken: helper::UniqueRandomXChar(69,'apiToken');
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updated_at = date("Y-m-d H:i:s");
        // dd($record);
        $record->save();
        
        return $record;
    }
    public function provider()
    {
        return $this->belongsTo("\App\Models\providers","providers_id");
    }   
    public function category()
    {
        return $this->belongsTo(categories::class,"categories_id");
    }   
    public function sessions()
    {
        return $this->hasMany('\App\Models\sessions','users_id');
    }
    public function reviews(){
        return $this->hasMany(reviews::class,'stores_id');
    }
    function GetRateAttribute(){
        return (double) ($this->reviews?$this->reviews->avg('rate'):0);
    }
    function GetSessionAttribute()
    {
        return $this->sessions->first()??null;
    }
    function GetDistanceAttribute()
    {
        $account= index::$account;
        if(!$account) return null;
        $location1= locations::where($account->getTable()."_id",$account->id)->orderBy("id","DESC")->first();
        $location2= locations::where("stores_id",$this->id)->orderBy("id","DESC")->first();
        if(!$location1 || !$location2)
            return null;
        return helper::distance($location1->latitude,$location1->longitude, $location2->latitude,$location2->longitude)    ;
    }
    function GetLocationAttribute()
    {
        return locations::where('stores_id',$this->id)->orderBy('id','desc')->first();
    }
    
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
        parent::setAttribute($key, $value);
        }
    }
    function GetHasOfferAttribute()
    {
        if($this->discount){
            if($this->start_at_offer <= date("Y-m-d") && $this->end_at_offer > date("Y-m-d"))
                return true;
        }
        return false;
    }

    public static function allActive()
    {
        
        return self::orderBy('id','DESC')->where('isActive',1)->get()->where('deletedAt',null);
    }
    function GetRegionsAttribute()
    {
        return stores::whereIn('id',
            stores_has_regions::where('stores_id',$this->id)->pluck('stores_id')->toArray()
        )->pluck('name')->toArray();
    }

}