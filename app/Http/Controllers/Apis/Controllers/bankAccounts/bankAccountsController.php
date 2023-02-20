<?php

namespace App\Http\Controllers\Apis\Controllers\bankAccounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\bank_accounts;

class bankAccountsController extends index
{
    public static function api()
    {
        $records=  bank_accounts::all()
                                ->makeHidden(["nameAr","nameEn","titleAr","titleEn","descriptionAr","descriptionEn","isActive","createdAt","categories_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "bankAccounts"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}