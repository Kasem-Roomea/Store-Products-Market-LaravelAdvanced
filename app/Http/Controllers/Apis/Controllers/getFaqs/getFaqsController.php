<?php
namespace App\Http\Controllers\Apis\Controllers\getFaqs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\faqs;

class getFaqsController extends index
{
    public static function api()
    {
        $records=  faqs::all();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "faqs"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"faq"),
        ];
    }
}