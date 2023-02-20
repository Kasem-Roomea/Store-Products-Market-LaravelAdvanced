<?php

namespace App\Http\Controllers\Apis\Controllers\resetPassword;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class resetPasswordRules extends index
{
    public static function rules()
    {

        $rules = [
            "email"    => "required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|",
            "phone"    => "required_if:email,|numeric|between:100000000,99999999999999999999",
            "newPassword" => "required|string|min:6",
        ];

        $messages = [
            "required_if"        => 400,
            "email.regex"        => 405,
            "email.min"          => 405,
            "email.unique"       => 409,

            "phone.required_if"  => 400,
            "phone.between"      => 405,

            "newPassword.required" => 405,
            "newPassword.min"      => 405,
        ];

        $messagesAr = [
            "required_if" => "يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.regex"       => "يجب ادخال البريد الالكتروني بشكل صحيح",

            "phone.nemeric"       => "يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"       => "يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",

            "newPassword.required" => "يجب ادخال الرقم السري الجديد",
            "newPassword.min"     => "يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

        ];

        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? 'showAllErrors' : 'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }
        self::$account->isVerified = 1;
        self::$account->save();
        return helper::validateAccount() ?? null;
    }
}
