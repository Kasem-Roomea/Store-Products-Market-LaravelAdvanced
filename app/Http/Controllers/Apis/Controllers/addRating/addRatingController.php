<?php
namespace App\Http\Controllers\Apis\Controllers\addRating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\reviews;
use Illuminate\Support\Str;

class addRatingController extends index
{
    public static function api()
    {
        
        foreach(self::$request->reviews as $review ){
            
                reviews::where(self::$account->getTable()."_id",self::$account->id)->where( $review["type"]."s_id", $review["targetId"])->delete();
                $type= Str::camel(Str::singular(self::$account->getTable())."_to_".$review["type"]);   
                 $records=  reviews::createUpdate([
                    "rate"=>$review['rate'],
                    "comment"=>$review['comment']??null,
                    $review["type"]."s_id"=>$review["targetId"],
                    "type"=> $type,
                    self::$account->getTable()."_id"=>self::$account->id,
                ]);
        }
        return [
            "status"=>200,
        ];
    }
}