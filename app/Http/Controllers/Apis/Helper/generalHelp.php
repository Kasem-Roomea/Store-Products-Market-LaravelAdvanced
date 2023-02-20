<?php

namespace App\Http\Controllers\Apis\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Support\Str;
use App\Models\admins;
use App\Models\categories;
use App\Models\app_settings;
use App\Models\emails;
use App\Models\favourites;
use App\Models\images_in_store;
use App\Models\locations;
use App\Models\contacts;
use App\Models\notifications;
use App\Models\notify;
use App\Models\orders;
use App\Models\phones;
use App\Models\providers;
use App\Models\rates;
use App\Models\requests_balance;
use App\Models\servicers_in_orders;
use App\Models\tokens;
use App\Models\services;
use App\Models\sessions;
use App\Models\stores;
use App\Models\users;
use App\Http\Controllers\Apis\Resources\objects;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Hash;
use Validator;
use DB;

class generalHelp extends index
{
	public static $itemPerPAge = 10;
	public static function base64_image($image_string, $folderName)
	{
		if (!$image_string) return null;
		// CHECK IF FOLDER EXIST 
		$folderPath = "uploads/{$folderName}/";
		if (!file_exists($folderPath))
			mkdir($folderPath, 0777, true);
		// START MAKE IMAGE

		$path = Str::random(16) . '.jpg';
		$file = fopen($folderPath . $path, "wb");
		fwrite($file, base64_decode($image_string));
		fclose($file);
		return "/" . $folderPath . $path;
	}
	public static function base64_image_dash($image_string, $folderName)
	{
		if (!$image_string) return null;
		// CHECK IF FOLDER EXIST 
		$folderPath = "uploads/{$folderName}/";
		if (!file_exists($folderPath))
			mkdir($folderPath, 0777, true);
		// START MAKE IMAGE
		$extension = (explode('/', explode(':', substr($image_string, 0, strpos($image_string, ';')))[1])[1]);
		$extension = Str::contains($extension, '+') ? explode('+', $extension)[0] : $extension;
		$path = Str::random(16) . '.' . $extension;
		$file = fopen($folderPath . $path, "wb");

		fwrite($file, base64_decode(explode(',', $image_string)[1]));
		fclose($file);
		return "/" . $folderPath . $path;
	}


	public static function uploadPhoto($image, $folderName, $name = null)
	{
		if (!$image) return null;
		$folderPath = "uploads/{$folderName}/";
		if (!file_exists($folderPath))
			mkdir($folderPath, 0777, true);
		if (!$name) {
			$name = Str::random(30) . now()->timestamp . '.' . $image->getClientOriginalExtension();
		}
		$image->move(public_path('uploads/' . $folderName), $name); //move function accept 2para('destnation','filename')
		return  '/uploads/' . $folderName . "/" . $name;
	}

	public static function chkifSendTwominute($session)
	{
		$now = (Carbon::parse('now')->subMinutes(2))->format('Y-m-d H:i:s');
		return ($session->createdAt <= $now) ? true : false;
	}

	public static function getAccount($api_token = null, $email = null, $phone = null, $tmpToken = null, $tmp_phone = null, $tmp_email = null)
	{
		$models = self::$providers;
		if ($api_token) {
			$key   = 'apiToken';
			$value = $api_token;
			$token = tokens::where('apiToken', self::$request->apiToken)->first();
			if ($token) {
				foreach ($models as $model) {
					if ($token->{Str::singular($model)})
						return $token->{Str::singular($model)};
				}
			} else
				return null;
		} elseif ($email) {
			$key   = 'email';
			$value = $email;
		} elseif ($phone) {
			$key   = 'phone';
			$value = $phone;
		} elseif ($tmpToken) {
			$session = sessions::where('tmpToken', $tmpToken)->first();
			if ($session == null) return null;
			foreach ($models as $model)
				if ($session->$model != null)
					return $session->$model;
		} elseif ($tmpToken != null) {
			$session = sessions::where('tmpPhone', $tmp_phone)->first();
			if ($session == null) return null;
			foreach ($models as $model)
				if ($session->$model != null)
					return $session->$model;
		} elseif ($tmp_email != null) {
			$session = sessions::where('tmp_email', $tmp_email)->first();
			if ($session == null) return null;
			foreach ($models as $model)
				if ($session->$model != null)
					return $session->$model;
		} else {
			return null;
		}
		foreach ($models as $model) {
			$tableName = "\App\Models\\" . $model;
			$record = $tableName::where($key, $value)->first();
			if ($record) return $record;
		}
	}

	public static function RandomXDigits($Digits = 6)
	{
		return rand(pow(10, $Digits - 1), pow(10, $Digits) - 1);
	}

	public static function UniqueRandomXDigits($Digits = 6, $column, $models = [])
	{

		$code = rand(pow(10, $Digits - 1), pow(10, $Digits) - 1);
		$models = $models ?? self::$providers;
		for ($i = 0; $i < count($models); $i++) {
			$model = '\App\Models\\' . $models[$i];
			if ($model::where($column, $code)->count() != 0) {
				$code = rand(pow(10, $Digits - 1), pow(10, $Digits) - 1);
				$i = 0;
			}
		}
		return $code;
	}

	public static function UniqueRandomXChar($Chars = 69, $column, $models = [])
	{

		$code = Str::random($Chars);
		$models = $models ?? self::$providers;
		for ($i = 0; $i < count($models); $i++) {
			$model = '\App\Models\\' . $models[$i];
			if ($model::where($column, $code)->count() != 0) {
				$code = Str::random($Chars);
				$i = 0;
			}
		}
		return $code;
	}

	public static function HashPassword($Password)
	{
		return Hash::make($Password);
	}

	public static function login($record, $password)
	{
		$check =	Hash::check($password, $record->password);
		if ($check) {
			$token = self::UniqueRandomXChar(69, 'apiToken');
			tokens::create([
				'apiToken' => $token,
				$record->getTable() . '_id' => $record->id,
				'created_at' => date('Y-m-d H:i:s')
			]);
			return $token;
		}
		return $check;
	}

	public static function createTmpTokens($record)
	{
		$token = self::UniqueRandomXChar(69, 'apiToken');
		tokens::create([
			'apiToken' => $token,
			$record->getTable() . '_id' => $record->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		return $token;
	}

	public static function changePassword()
	{
		$account = self::$account;
		$account->password = self::HashPassword(self::$request->newPassword);
		$account->save();
	}

	public static function updatePassword()
	{

		if (Hash::check(self::$request->oldPassword, self::$account->password) == false) {
			return false;
		} else {
			self::$account->password = self::HashPassword(self::$request->newPassword);
			self::$account->save();
			return true;
		}
	}

	public static function setAccountByession()
	{

		$key = self::$request->has('phone') ? 'tmpPhone' : 'tmpEmail';
		$value = self::$request->has('phone') ? self::$request->phone : self::$request->email;
		$seeions = $session = sessions::where($key, self::$request->phone)->first();

		if (!$seeions) return null;
		foreach (self::$providers as $provider) {
			$account = $seeions->$provider;
			if ($account) {
				self::$account = $account;
				self::$lang = $account->lang ?? 'ar';
				return true;
			}
		}
	}

	public static function validator($Request, $Rules, $Messages, $messagesLang)
	{
		$validator = Validator::make($Request, $Rules, $Messages);

		$code = null;
		if ($validator->fails()) {
			$code = $validator->errors()->first();
		}

		$validator = Validator::make($Request, $Rules, $messagesLang);
		if ($validator->fails()) {
			$message = $validator->errors()->first();
		}

		if ($code != null)
			return ['status' => (int)$code, 'message' => $message];
	}

	public static function showAllErrors($Request, $Rules, $Messages, $messagesLang)
	{
		$validator = Validator::make($Request, $Rules, $Messages);
		$code = null;
		if ($validator->fails()) {
			$code = $validator->errors();
		}

		$validator = Validator::make($Request, $Rules, $messagesLang);
		if ($validator->fails()) {
			$message = $validator->errors();
		}
		if ($code != null)
			return ['status' => $code, 'message' => $message];
	}

	public static function distance($lat1, $lon1, $lat2, $lon2)
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		//$unit = strtoupper($unit);

		return ($miles * 1.609344);
	}

	public static function isExpiredSession($session, $minutes)
	{
		$now = (Carbon::parse('now')->subMinutes($minutes));
		return $session->createdAt < $now ? true : false;
	}

	public static function sendFCM($pushNotify, $target)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		$body = $pushNotify->notification['content' . $pushNotify->$target->language];
		$fields = [
			"to" => $pushNotify->$target->firebaseToken,
			"priority" => "high",
			"content_available" => true,
			"mutable_content" =>  true,
			"notification" => [
				"body" => Str::words($pushNotify->content, 250, "."),
				"title" => $pushNotify->title,
				// "secondTitle" =>$pushNotify->notification->title,
				"icon" => "myicon",
				"sound" => "default",
				"click_action" => "FLUTTER_NOTIFICATION_CLICK"

			],
			"data" => [
				"order" => $pushNotify->order ? objects::order($pushNotify->order) : null
			]
		];

		$fields = json_encode($fields);
		$headers = [
			'Authorization: key=' . "AAAAXrKbQU4:APA91bFlTkhx1mD-nqUhCpLCG7U7eZN5VSeXVU8vY7BimqPoLPIzdHq2pjjL3RChjwsSe4xICeGvE217jJXGN3iqCEV7XgCqnbII2Wm_Q_Kt9qRi3qu-vVkZOTF0WypQAc6RoaMBmlg4",
			'Content-Type: application/json'
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		$result = curl_exec($ch);
		curl_close($ch);
		// dd($pushNotify->notification['content'.$pushNotify->$target->language]);
	}

	public static function deleteFile($path)
	{
		File::delete($_SERVER['DOCUMENT_ROOT'] . $path); // Value is not URL but directory file path
	}
}
