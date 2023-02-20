<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class faqs extends GeneralModel
{
    protected $table = 'faqs' ;

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->questionAr = isset($params["questionAr"])? $params["questionAr"]: $record->questionAr;
        $record->questionEn = isset($params["questionEn"])? $params["questionEn"]: $record->questionEn;
        $record->answerAr = isset($params["answerAr"])? $params["answerAr"]: $record->answerAr;
        $record->answerEn = isset($params["answerEn"])? $params["answerEn"]: $record->answerEn;
        $record->save();
        return $record;
    }
}   