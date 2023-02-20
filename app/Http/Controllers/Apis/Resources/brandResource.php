<?php
namespace App\Http\Controllers\Apis\Resources;

use App\Http\Controllers\Apis\Helper\helper ;
use  App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Http\Request;

class brandResource
{
    static function brand($record)
    {
        $obj=[
            'id'=>$record->id,
            'nameAr'=>$record->{'name'.index::$lang},
        ];
        return $obj;
    }
    static function brands ($records) :array
    {
        if($records->count() == 0) return (array)[];
        $Array = [];
        foreach ($records as $record) {
            $record ? $Array[] = self::brand($record) :null;
        }
        return $Array;
    }
}