<?php

namespace App\Http\Middleware;

use Closure; 
 
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Language 
{
    public function handle($request, Closure $next)
    {
        
            
        if(\Session()->get('local') == '') {
            $var = 'en';
        } else {
            $var = \Session()->get('local');
        }
        
        \App::setLocale($var);
        session()->put('local', $var);
    
        return $next($request);
    }
}
