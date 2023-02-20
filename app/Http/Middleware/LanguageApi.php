<?php

namespace App\Http\Middleware;

use Closure; 
 
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Apis\Controllers\index;

class LanguageApi 
{
    public function handle($request, Closure $next)
    {
        $lang=['Ar'=>'ar','En'=>'en'];        
        \App::setLocale($lang[index::$lang]);
        session()->put('local', $lang[index::$lang]);
    
        return $next($request);
    }
}
