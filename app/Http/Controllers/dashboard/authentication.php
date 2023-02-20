<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\drivers;
use App\Models\orders;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admins;
use App\Models\stores;
use Illuminate\Support\Facades\DB;
use Session as flash;
use Illuminate\Support\Facades\Hash;

class authentication extends Controller
{

    public static function index(Request $request){
        if(Auth::guard('dashboard')->check())
        {
            $users1 = users::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
            $users2 = users::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
            $users3 = users::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
            $users4 = users::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
            $users5 = users::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
            $users6 = users::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
            $users7 = users::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
            $users8 = users::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
            $users9 = users::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
            $users10 = users::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
            $users11 = users::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
            $users12 = users::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


            $drivers1 = drivers::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
            $drivers2 = drivers::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
            $drivers3 = drivers::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
            $drivers4 = drivers::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
            $drivers5 = drivers::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
            $drivers6 = drivers::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
            $drivers7 = drivers::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
            $drivers8 = drivers::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
            $drivers9 = drivers::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
            $drivers10 = drivers::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
            $drivers11 = drivers::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
            $drivers12 = drivers::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


            $stores1 = stores::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
            $stores2 = stores::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
            $stores3 = stores::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
            $stores4 = stores::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
            $stores5 = stores::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
            $stores6 = stores::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
            $stores7 = stores::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
            $stores8 = stores::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
            $stores9 = stores::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
            $stores10 = stores::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
            $stores11 = stores::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
            $stores12 = stores::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


            $orders1 = orders::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
            $orders2 = orders::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
            $orders3 = orders::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
            $orders4 = orders::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
            $orders5 = orders::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
            $orders6 = orders::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
            $orders7 = orders::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
            $orders8 = orders::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
            $orders9 = orders::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
            $orders10 = orders::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
            $orders11 = orders::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
            $orders12 = orders::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();

            $usersCount=users::count();
            $driversCount=drivers::count();
            $ordersCount=orders::count();
            $storesCount=stores::count();

            return view('index', compact('users1','users2','users3','users4','users5','users6','users7','users8','users9','users10','users11','users12','drivers1','drivers2','drivers3','drivers4','drivers5','drivers6','drivers7','drivers8','drivers9','drivers10','drivers11','drivers12','stores1','stores2','stores3','stores4','stores5','stores6','stores7','stores8','stores9','stores10','stores11','stores12','orders1','orders2','orders3','orders4','orders5','orders6','orders7','orders8','orders9','orders10','orders11','orders12'
                ,'usersCount','driversCount','ordersCount','storesCount'));
        }else
            {
                return "kasem";
            }


    }

  public static function login(Request $request){
       
        $rules =[
            'email'       =>'required|email',
            'password'    =>"required|",
        ];
        $messages=[
            "email.required"=>"يجب إدخال البريد الإلكتروني",
            "email.regex"=>"يجب إدخال البريد الإلكتروني بشكل صحيح",
            "email.exists"=>"البريد الإلكتروني غير صحيح",
 
            "password.required"  =>"يجب إدخال الرقم السري",
        ];
        $request->validate($rules, $messages);

         $auth = admins::where('email',$request->email)->first();
      $auth = admins::where('email',$request->email)->first();
      $guard= "dashboard";
      $redirect= "statistics";
      if(! $auth){
          $auth = stores::where('email',$request->email)->first();
          $guard= "stores";

          if(!$auth ){
              flash::flash('incorrectEmail',' بريد إلكتروني غير صحيح ');
              return back();
          }

          if(!$auth->isActive){
              flash::flash('incorrectPassword','متجر غير مفعل , برجاء التواصل مع الادارة');
              return back();
          }
      }
      if(!$auth ){
          flash::flash('incorrectEmail',' بريد إلكتروني غير صحيح ');
          return back();
      }

      if(Hash::check($request->password , $auth->password )){
          \Auth::guard($guard)->login( $auth);
      }else{
          flash::flash('incorrectPassword','كلمة مرور خاطئة');
          return back();
      }


      $users1 = users::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
      $users2 = users::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
      $users3 = users::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
      $users4 = users::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
      $users5 = users::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
      $users6 = users::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
      $users7 = users::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
      $users8 = users::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
      $users9 = users::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
      $users10 = users::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
      $users11 = users::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
      $users12 = users::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


      $drivers1 = drivers::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
      $drivers2 = drivers::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
      $drivers3 = drivers::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
      $drivers4 = drivers::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
      $drivers5 = drivers::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
      $drivers6 = drivers::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
      $drivers7 = drivers::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
      $drivers8 = drivers::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
      $drivers9 = drivers::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
      $drivers10 = drivers::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
      $drivers11 = drivers::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
      $drivers12 = drivers::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


      $stores1 = stores::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
      $stores2 = stores::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
      $stores3 = stores::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
      $stores4 = stores::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
      $stores5 = stores::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
      $stores6 = stores::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
      $stores7 = stores::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
      $stores8 = stores::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
      $stores9 = stores::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
      $stores10 = stores::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
      $stores11 = stores::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
      $stores12 = stores::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();


      $orders1 = orders::whereBetween('createdAt',[date('Y-1-1'),date('Y-1-31')])->count();
      $orders2 = orders::whereBetween('createdAt',[date('Y-2-1'),date('Y-2-31')])->count();
      $orders3 = orders::whereBetween('createdAt',[date('Y-3-1'),date('Y-3-31')])->count();
      $orders4 = orders::whereBetween('createdAt',[date('Y-4-1'),date('Y-4-31')])->count();
      $orders5 = orders::whereBetween('createdAt',[date('Y-5-1'),date('Y-5-31')])->count();
      $orders6 = orders::whereBetween('createdAt',[date('Y-6-1'),date('Y-6-31')])->count();
      $orders7 = orders::whereBetween('createdAt',[date('Y-7-1'),date('Y-7-31')])->count();
      $orders8 = orders::whereBetween('createdAt',[date('Y-8-1'),date('Y-8-31')])->count();
      $orders9 = orders::whereBetween('createdAt',[date('Y-9-1'),date('Y-9-31')])->count();
      $orders10 = orders::whereBetween('createdAt',[date('Y-10-1'),date('Y-10-31')])->count();
      $orders11 = orders::whereBetween('createdAt',[date('Y-11-1'),date('Y-11-31')])->count();
      $orders12 = orders::whereBetween('createdAt',[date('Y-12-1'),date('Y-12-31')])->count();



      $usersCount=users::count();
      $driversCount=drivers::count();
      $ordersCount=orders::count();
      $storesCount=stores::count();


      return view('index', compact('users1','users2','users3','users4','users5','users6','users7','users8','users9','users10','users11','users12','drivers1','drivers2','drivers3','drivers4','drivers5','drivers6','drivers7','drivers8','drivers9','drivers10','drivers11','drivers12','stores1','stores2','stores3','stores4','stores5','stores6','stores7','stores8','stores9','stores10','stores11','stores12','orders1','orders2','orders3','orders4','orders5','orders6','orders7','orders8','orders9','orders10','orders11','orders12'
          ,'usersCount','driversCount','ordersCount','storesCount'));

    }

    private  static function Query($tableNAme)
    {
        return DB::table($tableNAme)
            ->select(
                DB::raw('COUNT(id) as `value`'),
                DB::raw("MONTH(createdAt) as `month`")
            )
            ->where(DB::raw("YEAR(createdAt)"), '=', date('Y'))
            ->groupBy('month')
            ->get();
    }

    public static function logout(Request $request){
        
        if(Auth::guard('dashboard')->check()){
            \Auth::guard('dashboard')->logout();
        }else{
            \Auth::guard('stores')->logout();
        };
        return redirect()->route('adminLogin');
}

}
