<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Str;

class dashboard
{
    
    public function handle($request, Closure $next)
    {
        if(Auth::guard('dashboard')->check()) { 
            if(Auth::guard('dashboard')->user()->isSuperAdmin){
                return $next($request);
            }else{
                if(explode( '/' ,url()->previous())[4] == 'login'){
                    return $next($request);
                }else{
                    $currentRequest= \Request::segment(2);
                    $permissionsOfThis= (json_decode(Auth::guard('dashboard')->user()->permissions , true))[$currentRequest]??false;
                    // dd($permissionsOfThis);
                    $permissionsName= [
                        null=>$permissionsOfThis['view']??false,
                        'createUpdate'=>$request->id?$permissionsOfThis['edit']??false:$permissionsOfThis['add']??false,
                        'delete'=>$permissionsOfThis["delete"]??false,
                    ]; 
                    
                    if( $permissionsName[\Request::segment(3)]??false){
                            return $next($request);
                    }elseif(!isset( $permissionsName[\Request::segment(3)]) ){
                        return $next($request);
                    }else{
                        abort(403);
                    }
                }
            return $next($request);
            }   
        }elseif(Auth::guard('stores')->check()){
            if(!Auth::guard('stores')->user()->isActive){
                \Auth::guard('stores')->logout(); 
                return redirect()->route('dashboard.login.index');
            }
            if(!in_array(\Request::segment(2),['categories','products',"orders"],true)){
                return redirect()->route('dashboard.categories.index');
            }
            return $next($request);
        }else{     
          return redirect()->route('dashboard.login.index');
        }
    }
}
