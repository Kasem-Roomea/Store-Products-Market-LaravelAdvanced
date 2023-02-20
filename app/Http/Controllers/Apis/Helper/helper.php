<?php

namespace App\Http\Controllers\Apis\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\admins;
use App\Models\ads;
use App\Models\app_settings;
use App\Models\contacts;
use App\Models\logs;
use App\Models\notifications;
use App\Models\notify;
use App\Models\sessions;
use App\Models\users;
use App\Models\points;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use Validator;
use DB;
use GuzzleHttp\Client;

class helper extends generalHelp
{
	public static function validateAccount()
	{

		if (index::$account == null) {
			if (index::$request->has('phone')) {
				$code = 415;
			} elseif (index::$request->has('email')) {
				$code = 416;
			} elseif (index::$request->has('tmpToken')) {
				$code = 417;
			} elseif (index::$request->has('apiToken')) {
				$code = 403;
			} else {
				return null;
			}
		} else {
			if (index::$account->deletedAt != null) {
				$code = 418;
			} elseif (index::$account->isActive == 0) {
				$code = 402;
			} elseif (index::$account->isVerified == 0) {
				sessions::where('users_id', self::$account->id)->delete();
				$session = sessions::createUpdate([
					self::$account->getTable() . "_id" => self::$account->id,
					'code' => self::RandomXDigits(4)
				]);
				helper::sendSMS(self::$account->phone, $session->code);
				$code = 419;
			} else {
				return null;
			}
		}
		return [
			'status' => $code,
			'message' => self::$messages['validateAccount']["{$code}"],
		];
	}

	public static function newNotify($targets, $message_ar, $message_en, $orderId = null, $type = null, $notificationId = null, $titleAr = null, $titleEn = null)
	{
		if (!$notificationId) {
			$notification   =   notifications::createUpdate([
				'contentAr' => $message_ar,
				'contentEn' => $message_en,
				'titleAr' => $titleAr,
				'titleEn' => $titleEn,
				'type'    => $type
			]);
		}

		foreach ($targets as $user) {
			if ($user != null) {
				$notify =   notify::createUpdate([
					'notifications_id' => $notificationId ?? $notification->id,
					$user->getTable() . "_id" => $user->id,
					'orders_id'      => $orderId,
					'isSeen'         => 0,
					'type'           => $type
				]);
				self::sendFCM($notify, 'target_user');
				error_log("end");
			}
		}
		return $notificationId ?? $notification->id;
	}

	public static function SocketUser($userId, $type, $data)
	{
		$curl = curl_init("http://127.0.0.1:7779/user/" . $userId);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$curl,
			CURLOPT_POSTFIELDS,
			json_encode([
				'type' => $type,
				'data' => $data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	public static function SocketDriver($userId, $type, $data)
	{
		$curl = curl_init("http://127.0.0.1:7779/driver/" . $userId);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$curl,
			CURLOPT_POSTFIELDS,
			json_encode([
				'type' => $type,
				'data' => $data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	public static function SocketStore($userId, $type, $data)
	{
		$curl = curl_init("http://127.0.0.1:7779/store/" . $userId);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt(
			$curl,
			CURLOPT_POSTFIELDS,
			json_encode([
				'type' => $type,
				'data' => $data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	public static function sendSMS($phone, $msg)
	{
		$phone = Str::substr($phone, 2, 70);
		error_log("send sms");
		error_log('phone' . $phone);
		error_log('msg' . $msg);

		$url = 'http://api.edsfze.com/http/sendsms.aspx?apikey=5c290638-cf5f-4c82-a721-9f0299c55c40202184&msgtype=0&dlr=1&sid=AD-UAESTORE&mobiles=' . $phone . '&msg=' . $msg;
		$url = preg_replace("/ /", "%20", $url);
		error_log($url);
		self::get_web_page($url);
	}
	public static function converPointsToBalance($pointsToBeConverted)
	{
		$points = points::orderBy("numberOfPoints", "ASC")->get();
		$check = false;
		$pointRturned = 0;
		foreach ($points as $point) {
			if ($point->numberOfPoinValidatorts <= $pointsToBeConverted) {
				$check = true;
				$pointRturned = $point;
				continue;
			}
		}
		if ($pointRturned)
			return $pointRturned;
		else {
			return points::orderBy("numberOfPoints", "DESC")->first();
		}
	}
	public static function get_web_page($url, $cookiesIn = '')
	{
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => true,     //return headers in addition to content
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLINFO_HEADER_OUT    => true,
			CURLOPT_SSL_VERIFYPEER => true,     // Validate SSL Cert
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_COOKIE         => $cookiesIn
		);

		$ch      = curl_init($url);
		curl_setopt_array($ch, $options);
		$rough_content = curl_exec($ch);
		$err     = curl_errno($ch);
		$errmsg  = curl_error($ch);
		$header  = curl_getinfo($ch);
		curl_close($ch);

		$header_content = substr($rough_content, 0, $header['header_size']);
		$body_content = trim(str_replace($header_content, '', $rough_content));
		$pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m";
		preg_match_all($pattern, $header_content, $matches);
		$cookiesOut = implode("; ", $matches['cookie']);

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['headers']  = $header_content;
		$header['content'] = $body_content;
		$header['cookies'] = $cookiesOut;
		return $header;
	}
	public static function getCityIdBylocation($location)
	{
		$geolocation = $location->latitude . ',' . $location->longitude;
		$request = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBEwPwwl2GyxB_o5XIftcK9byycorBeWBA&latlng=' . $geolocation . '&sensor=false';
		$file_contents = self::get_web_page($request)['content'];
		$json_decode = json_decode($file_contents, true);
		// return $json_decode;
		$index = count($json_decode['results'][0]["address_components"]);
		$cityName = $json_decode['results'][0]["address_components"][$index - 2]["long_name"];
		// return  $cityName;
		// $regions = regions::where('regions_id','!=',null)->get()->filter(function($item) use ($cityName) {
		// 	if( stripos($item['name_ar'],$cityName) !== false || stripos($item['name_en'],$cityName) !== false)
		// 		return true;
		// 	return false;
		// });
		// if($regions->first())
		// 	return $regions->first()->id;
		// return $cityName;
	}
}
