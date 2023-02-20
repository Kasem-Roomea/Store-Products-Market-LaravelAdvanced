<?php

namespace App\Http\Controllers\Apis\Controllers;

use App\Http\Controllers\Apis\Helper\helper ;

use App\Models\admins; 
use App\Models\app_settings;
use App\Models\categories;
use App\Models\days;
use App\Models\emails;
use App\Models\favourites;
use App\Models\contacts;
use App\Models\images_in_store;
use App\Models\locations;
use App\Models\notifications;
use App\Models\notify;
use App\Models\orders;
use App\Models\phones;
use App\Models\providers;
use App\Models\rates;
use App\Models\regions;
use App\Models\request_balance;
use App\Models\services;
use App\Models\services_in_orders;
use App\Models\services_in_store;
use App\Models\stores;
use App\Models\sessions;
use App\Models\users;
use App\Models\GeneralModel;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class index extends Controller
{
    public static   $account,$request,$secondAccount,$isSendMessage=false,$itemPerPage=20,
                    $className,$classRules,$lang,$providers=['users','drivers','stores'],$messages,$messagesAll;
    
    function __construct(Request $request){

        if($request->has('phone'))     
            $request->offsetSet('phone',Str::replaceFirst('+', '00',$request->phone ));
       
        self::$request=$request;
        self::setAccount($request);
        self::setSecondAccount();
        self::setClassName();
        self::setClassRules();
        self::setLang();
        $messages=include "lang.php";
        self::$messages=$messages[self::$lang];
        self::$messagesAll=$messages;
    }
    
    public static function index(){
        return response()->json( self::$classRules::rules()??self::$className::api() );
    }

    public static function setAccount($request){
        
        if($request->has('apiToken')){
            self::$account=helper::getAccount($request->apiToken,null,null);     
        }elseif($request->has('phone')){
            self::$account=helper::getAccount(null,null,$request->phone);
        }elseif($request->has('email')){
            self::$account=helper::getAccount(null,$request->email,null);          
        }elseif($request->has('tmpToken')){
            self::$account=helper::getAccount(null,null,null,$request->tmpToken);          
        }
    }

    public static function setSecondAccount(){
        if(self::$request->has('userId')){
            self::$secondAccount =  users::find(self::$request->userId); 
        }elseif(self::$request->has('providerId')){
            self::$secondAccount =  providers::find(self::$request->providerId); 
        }else{  
            self::$secondAccount==null;
        }
    }

    public static function setClassName(){
        $requestName=self::$request->segment(2);
        self::$className= 'App\Http\Controllers\Apis\Controllers\\'.$requestName.'\\'.$requestName.'Controller';
    }

    public static function setClassRules(){
        $requestName=self::$request->segment(2);
        self::$classRules= 'App\Http\Controllers\Apis\Controllers\\'.$requestName.'\\'.$requestName.'Rules';
    }

    
    public static function setLang(){
    
        if(self::$request->has('language')&& in_array(self::$request->language,['Ar','En'])){
            self::$lang=self::$request->language;
        }elseif(self::$account && self::$account->language ){
            self::$lang=self::$account->language;
        }else{
              self::$lang='Ar';
        }
    }
}