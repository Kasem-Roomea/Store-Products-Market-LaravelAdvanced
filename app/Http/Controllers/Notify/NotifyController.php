<?php

namespace App\Http\Controllers\Notify;

use App\Http\Controllers\Controller;
use App\Jobs\sendNotifications;
use App\Models\drivers;
use App\Models\notifications;
use App\Models\notify;
use App\Models\stores ;
use App\Models\users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\replace;


class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public  $request;
    function __construct(Request $request)
    {
            $this->request =$request;
    }
    public function index()
    {
        try {
            $Notifications = Notifications::get();
            $viewNotify = notify::with('notificationsViewUsers');
            return view('Notifications.Notifications', compact('Notifications', 'viewNotify'));
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                "titleAr" => "required|min:3",
                "titleEn" => "required|min:3",
                "contentAr" => "required|min:3",
                "contentEn" => "required|min:3",
            ];
            $messages = [

                "titleAr.required" => "يجب ادخال العنوان بالعربي",
                "titleAr.min" => "يجب ان لا يقل العنوان بالعربي عن 3 حروف ",

                "titleEn.required" => "يجب ادخال العنوان بالانجليزي",
                "titleEn.min" => "يجب ان لا يقل العنوان بالانجليزي عن 3 حروف ",

                "contentAr.required" => "يجب ادخال المحتوي بالعربي",
                "contentAr.min" => "يجب ان لا يقل المحتوي بالعربي عن 3 حروف ",

                "contentEn.required" => "يجب ادخال المحتوي بالانجليزي",
                "contentEn.min" => "يجب ان لا يقل المحتوي بالانجليزي عن 3 حروف ",
            ];

            $validated = $request->validate($rules, $messages);


            $file_name = Null;
            //التشييك على أضافة صورة
            if (isset($request->image) && !empty($request->image)) {
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
            }

            //أضافة الاشعار الى جدول الاشعارات
            $record = Notifications::create([
                'titleAr' => $request->titleAr,
                'titleEn' => $request->titleEn,
                'contentAr' => $request->contentAr,
                'contentEn' => $request->contentEn,
                'createdAt' => now(),
                'image' => $file_name,
            ]);

            $notification_id = Notifications::select('id')->orderby('id' , 'DESC')->first();

            if ( $file_name != Null) {
                $imageNotify = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/notify/'.$notification_id->id), $imageNotify);
            }

            // sendNotifications::dispatch($record,$request->typeUsers);
            //تسجيل الاشعارات للمستخدمين المحددين
            //start Notify User or Drivers or Stores In Table Notify
            if($request->typeUsers == 'all')
            {
                $models=['App\Models\users','App\Models\drivers','App\Models\stores'];
            }
            else if($request->typeUsers == 'drivers')
            {
                $models=['App\Models\drivers'];
            }
            else if($request->typeUsers == 'users')
            {
                $models=['App\Models\users'];
            }
            else if($request->typeUsers == 'stores')
            {
                $models=['App\Models\stores'];
            }
            $models = $request->typeUsers?$models:[$request->typeUsers];
            foreach($models as $model){
                $modelClass= $model;
                $modelClass::where('isActive',1)->chunk(100, function($record) use($model){
                    $notification_id = Notifications::select('id')->orderby('id' , 'DESC')->first();
                    $newModel = explode('\\' ,$model );
                    foreach($record as $recorded){

                        $notify = notify::create([
                            "notifications_id"=> $notification_id->id,
                            "isSeen"=>0,
                            $newModel[2]."_id"=>$recorded->id,
                            'createdAt' => now(),
                        ]);
                    }
                });
            }
              //End Notify User or Drivers or Stores In Table Notify
            toastr()->success("تم أضافة الأشعار بنجاح", "رسالة نجاح ");
            return redirect('/notify');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $rules = [
                "titleAr" => "required|min:3",
                "titleEn" => "required|min:3",
                "contentAr" => "required|min:3",
                "contentEn" => "required|min:3",
            ];
            $messages = [

                "titleAr.required" => "يجب ادخال العنوان بالعربي",
                "titleAr.min" => "يجب ان لا يقل العنوان بالعربي عن 3 حروف ",

                "titleEn.required" => "يجب ادخال العنوان بالانجليزي",
                "titleEn.min" => "يجب ان لا يقل العنوان بالانجليزي عن 3 حروف ",

                "contentAr.required" => "يجب ادخال المحتوي بالعربي",
                "contentAr.min" => "يجب ان لا يقل المحتوي بالعربي عن 3 حروف ",

                "contentEn.required" => "يجب ادخال المحتوي بالانجليزي",
                "contentEn.min" => "يجب ان لا يقل المحتوي بالانجليزي عن 3 حروف ",
            ];

            $validated = $request->validate($rules, $messages);
            $notifyUpdate = notifications::findOrFail($request->id);

            $file_name = $notifyUpdate->image;
            //التشييك على أضافة صورة
            if (isset($request->image) && !empty($request->image))
            {
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
                Storage::disk('public_uploads_notify')->deleteDirectory($notifyUpdate->id);
                $imageNotify = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/notify/' . $notifyUpdate->id), $imageNotify);
            }

            //تعديل الاشعار الى جدول الاشعارات
            $notifyUpdate->update([
                'titleAr' => $request->titleAr,
                'titleEn' => $request->titleEn,
                'contentAr' => $request->contentAr,
                'contentEn' => $request->contentEn,
                'image' => $file_name,
            ]);
            //حذف الاشعارات عند المستخدمين
            notify::where('notifications_id', $notifyUpdate->id)->delete();

            $record = $notifyUpdate;
            //sendNotifications::dispatch($record, $request->typeUsers);

            //أضافة الاشعارات للمستخدمين
            //start Notify User or Drivers or Stores In Table Notify
            if($request->typeUsers == 'all')
            {
                $models=['App\Models\users','App\Models\drivers','App\Models\stores'];
            }
            else if($request->typeUsers == 'drivers')
            {
                $models=['App\Models\drivers'];
            }
            else if($request->typeUsers == 'users')
            {
                $models=['App\Models\users'];
            }
            else if($request->typeUsers == 'stores')
            {
                $models=['App\Models\stores'];
            }
            $models = $request->typeUsers?$models:[$request->typeUsers];
            foreach($models as $model){
                $modelClass= $model;
                $modelClass::where('isActive',1)->chunk(100, function($record) use($model){
                    $notifyUpdate = notifications::findOrFail($this->request->id);
                    $newModel = explode('\\' ,$model );
                    foreach($record as $recorded){

                        $notify = notify::create([
                            "notifications_id"=> $notifyUpdate->id,
                            "isSeen"=>0,
                            $newModel[2]."_id"=>$recorded->id,
                            'createdAt' => now(),
                        ]);
                    }
                });
            }
            //End Notify User or Drivers or Stores In Table Notify
            toastr()->success("تم تعديل الأشعار بنجاح", "رسالة نجاح ");
            return redirect('/notify');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try
        {
            $notification = notifications::findOrFail($request->id);
            Storage::disk('public_uploads_notify')->deleteDirectory($notification->id);
            $notification->delete();
            toastr()->error('تم حذف الأشعار بنجاح بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
