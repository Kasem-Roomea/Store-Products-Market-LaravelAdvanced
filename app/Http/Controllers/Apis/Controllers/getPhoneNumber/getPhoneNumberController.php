<?php

namespace App\Http\Controllers\Apis\Controllers\getPhoneNumber;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\objects;

class getPhoneNumberController extends index
{
    public static function api()
    {
        if (self::$account != null) {
            return [
                'status' => 200,
                'Account' => objects::account(self::$account),
                'message' => self::$messages['login']['200']
            ];
        } else {
            return [
                'status' => 404,
                'message' => "This user doesn't exist",
            ];
        }
    }
}
