<?php

namespace App\Http\Controllers\Apis\Controllers\resendCode;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Apis\Helper\helper;

class resendCodeRules extends index
{

    public static function rules()
    {

        $rules = [
            "phone" => "required|numeric|between:10000000000,99999999999999999999",
            "type"     => "required|in:user,driver,store",
        ];

        $messages = [
            "type.required"      => 400,
            "type.in"            => 405,

            "phone.required"     => 400,
            "phone.numeric"     => 405,
            "phone.between"     => 405,
        ];

        $messagesAr = [
            "type.required"     => "يجب ادخال نوع المستخدم",
            "type.in"           => " user,driver,store يجب ان يكون النوع  ",

            "phone.required" => "يجب ادخال رقم التليفون",
            "phone.numeric"     => "يجب ادخال رقم التليفون بشكل صحيح",
            "phone.between"     => "يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
        ];
        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? 'showAllErrors' : 'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }

        $tableName = "\App\Models\\" . Str::plural(request()->type);
        self::$account = $tableName::where('phone', request()->phone)->first();
        /* if (index::$account == null) helper::setAccountByession();
        if (!self::$account) {
            return [
                'status' => 415,
                'message' => self::$messages['validateAccount']["415"]
            ];
        } elseif (!self::$account->session) {
            return [
                "status" => 404,
            ];
        }*/
    }
}
