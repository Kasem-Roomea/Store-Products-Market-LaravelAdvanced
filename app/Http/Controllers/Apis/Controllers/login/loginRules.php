<?php

namespace App\Http\Controllers\Apis\Controllers\login;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use Illuminate\Support\Str;

class loginRules extends index
{

    public static function rules()
    {

        $rules = [
            "email"    => "required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|",
            "phone"    => "required_if:email,|numeric|between:100000000,99999999999999999999",
            "password" => "required|min:6|max:20",
            "language"          => "in:Ar,En",
            "type"     => "required|in:user,driver,store",
        ];

        $messages = [
            "language.in"            => 405,

            "type.required"      => 400,
            "type.in"            => 405,

            "required_if"        => 400,
            "email.regex"        => 405,
            "email.min"          => 405,
            "email.unique"       => 409,

            "phone.required_if"     => 400,
            "phone.numeric"      => 405,
            "phone.between"      => 405,

            "password.required"  => 400,
            "password.min"       => 405,
            "password.max"       => 405,

            "isAndroid.required" => 405,
            "isAndroid.in"       => 405
        ];

        $messagesAr = [
            "type.required"     => "يجب ادخال نوع المستخدم",
            "type.in"           => " user,driver,store يجب ان يكون النوع  ",

            "language.in"           => " Ar Or En يجب ان يكون اللغة  ",

            "required_if" => "يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.regex"       => "يجب ادخال البريد الالكتروني بشكل صحيح",

            "phone.nemeric"       => "يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"       => "يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",

            "password.required"  => "يجب ادخال الرقم السري ",
            "password.min"       => "يجب ان لا يقل الرقم السري عن 6 حروف وارقام",
            "password.max"       => "يجب ان لا يزيد الرقم السري عن 20 حرف",

            "isAndroid.required" => "يجب ادخال نوع النظام التشغيل ",
            "isAndroid.in"      => "يجب ادخال نوع النظام التشغيل بشكل صحيح",
        ];

        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? 'showAllErrors' : 'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "Ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }

        $tableName = "\App\Models\\" . Str::plural(request()->type);
        // self::$account = $tableName::where('phone', request()->phone)->first();

        if (index::$request->has('phone')) {
            self::$account = $tableName::where('phone', request()->phone)->first();
        } elseif (index::$request->has('email')) {
            self::$account = $tableName::where('email', request()->email)->first();
        }

        return helper::validateAccount() ?? null;

        // if(!self::$account)
        //     return [
        //         'status'=>405,
        //         'message'=>self::$messages['validateAccount']['415']
        //     ];
    }
}
