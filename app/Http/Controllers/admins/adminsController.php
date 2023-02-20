<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Illuminate\Http\Request;

class adminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $admins = admins::all();
            return view('admins.admins' , compact('admins'));
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
            $rule = [
                "name" => "required|min:3",
                "email" => "required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:admins,email",
                "password" => "nullable|min:6",
            ];

            $messages = [

                "name.required" => "يجب ادخال الاسم",
                "name.min" => "يجب ان لا يقل الاسم عن 3 حروف ",

                "email.regex" => "يجب ادخال البريد الالكتروني بشكل صحيح",
                "email.min" => "يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
                "email.unique" => "هذا البريد مسجل مسبقا",

                "password.min" => "يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

            ];
            $validated = $request->validate($rule, $messages);
            $configPermissions = config('helperDashboard.permission');
            $permission = [];
            foreach ($configPermissions as $key => $value) {
                $permission[$key] = [
                    "view" => $request->has($key . "_view") ? 1 : 0,
                    "add" => $request->has($key . "_add") ? 1 : 0,
                    "edit" => $request->has($key . "_edit") ? 1 : 0,
                    "delete" => $request->has($key . "_delete") ? 1 : 0,
                ];
            }

            $record = admins::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'permissions' => json_encode($permission),
                'createdAt' => now(),
            ]);

            toastr()->success("تم أضافة مسؤول جديد بنجاح", "رسالة نجاح ");
            return redirect('/admins');
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
            $rule = [
                "name" => "required|min:3",
                "email" => "required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:admins,email," . $request->id,
                "password" => "min:6",
            ];

            $messages = [

                "name.required" => "يجب ادخال الاسم",
                "name.min" => "يجب ان لا يقل الاسم عن 3 حروف ",

                "email.regex" => "يجب ادخال البريد الالكتروني بشكل صحيح",
                "email.min" => "يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
                "email.unique" => "هذا البريد مسجل مسبقا",

                "password.min" => "يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

            ];

            $validated = $request->validate($rule, $messages);
            $adminUpdate = admins::findOrFail($request->id);

            if(empty($request->password))
            {
                $newPassword = decrypt($adminUpdate->password);
            }else
            {
                $newPassword = $request->password;
            }
            $adminUpdate->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($newPassword),
                'isSuperAdmin' => $request->isSuperAdmin,

            ]);
            toastr()->success("تم تعديل المسؤول بنجاح", "رسالة نجاح ");
            return redirect('/admins');
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
            $admins = admins::findOrFail($request->id);
            $admins->delete();
            toastr()->error('تم حذف المسؤول بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updatePermissions(Request $request)
    {
        try {
            $configPermissions = config('helperDashboard.permission');
            $permission = [];
            foreach ($configPermissions as $key => $value) {
                $permission[$key] = [
                    "view" => $request->has($key . "_view") ? 1 : 0,
                    "add" => $request->has($key . "_add") ? 1 : 0,
                    "edit" => $request->has($key . "_edit") ? 1 : 0,
                    "delete" => $request->has($key . "_delete") ? 1 : 0,
                ];
            }
            $adminUpdatePermissions = admins::findOrFail($request->id);
            $adminUpdatePermissions->update([
                'permissions' => json_encode($permission),
            ]);

            toastr()->success("تم تعديل صلاحيات المسؤول بنجاح", "رسالة نجاح ");
            return redirect('/admins');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
