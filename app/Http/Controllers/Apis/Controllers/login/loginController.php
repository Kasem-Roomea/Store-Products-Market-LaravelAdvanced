<?php
namespace App\Http\Controllers\Apis\Controllers\login;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\notifications;
use App\Models\stores;
use App\Models\users;
use App\Models\drivers;
use App\Http\Controllers\Apis\Helper\helper ;

class loginController extends index
{
    public static function api()
    {
        $token = helper::login(self::$account,self::$request->password);
        if( $token){
            $validateAccount= helper::validateAccount();
            if($validateAccount) return $validateAccount;
            if(self::$account->getTable() != self::$request->type."s" ){
                return  [
                    'status'=>408,
                    'message'=>self::$messages['login']['408'],
                    
                ];
            }
            if(self::$account->getTable() == 'drivers' && !self::$account->isApproved)
                return  [
                    'status'=>416,
                    'message'=>self::$messages['login']['416'],
                    

                ];
            if(self::$request->has('lang')){
                self::$account->lang=self::$request->lang;
                self::$account->save();
            }
            self::$account['apiToken'] = $token;

            return  [
                'status'=>200,
                'Account'=>objects::account( self::$account),
                'message'=>self::$messages['login']['200']
            ];
        }else{
            return [
                'status'=>406,
                'message'=>self::$messages['login']['406'],
                
            ];
        }
    }
}