<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = users::get();
            return view('users.users', compact('users'));
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
            $messages = [
                'name.required' => 'الأسم مطلوب',
                'name.min' => 'يجب ان يكون عدد احرف الاسم اكثر من ثلاثة احرف',
                'email.required' => 'الأيميل مطلوب',
                'email.email' => 'يجب ان يكون من صيغة الايميل ',
                'email.unique' => 'يجب ان يكون البريد الألكتروني فريد من نوعه  ',
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'رقم الهاتف يجب ان يكون ارقا',
                'phone.unique' => 'رقم الهاتف يجب ان يكون فريد من نوعه',
                'password.required' => 'كلمة السر مطلوبة',
                'password.min' => 'كلمة السر يجب ان تكون اكثر من ستة أحرف',
                'balance.numeric' => 'الرصيد يجب ان يكون عدد صحيح ',
                'cashback.numeric' => 'الكاش باك يجب ان يكون عدد صحيح',
            ];
            $rule = [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|unique:users,phone',
                'password' => 'required|min:6',
                'balance' => 'numeric',
                'cashback' => 'numeric',
            ];
            $validated = $request->validate($rule, $messages);

            //التشييك على ان كان هناك قيمة كاش باك مرسلة ام لا
            if(isset($request->cashback) && !empty($request->cashback))
            {
                $cachback = $request->cashback;
            }
            else
                {
                    $cachback = Null;
                }
            $file_name = Null;
            //التشييك على أضافة صورة
            if(isset($request->image) && !empty($request->image))
            {
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
                $imageUsers = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/users/'.$request->phone), $imageUsers);
            }




            users::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'cashback' => $cachback,
                "language"=>"Ar",
                'createdAt' => now(),
                'updated_at' => now(),
                'image' => $file_name,
            ]);

            toastr()->success("تم أضافة مستخدم جديد بنجاح", "رسالة نجاح ");
            return redirect('/users');
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
            $messages = [
                'name.required' => 'الأسم مطلوب',
                'name.min' => 'يجب ان يكون عدد احرف الاسم اكثر من ثلاثة احرف',
                'email.required' => 'الأيميل مطلوب',
                'email.email' => 'يجب ان يكون من صيغة الايميل ',
                'email.unique' => 'يجب ان يكون البريد الألكتروني فريد من نوعه  ',
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'رقم الهاتف يجب ان يكون ارقا',
                'phone.unique' => 'رقم الهاتف يجب ان يكون فريد من نوعه',
                'password.min' => 'كلمة السر يجب ان تكون اكثر من ستة أحرف',
                'balance.numeric' => 'الرصيد يجب ان يكون عدد صحيح ',
                'cashback.numeric' => 'الكاش باك يجب ان يكون عدد صحيح',
            ];
            $rule = [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$request->id,
                'phone' => 'required|numeric|unique:users,phone,'.$request->id,
                'password' => 'min:6',
                'balance' => 'numeric',
                'cashback' => 'numeric',
            ];
            $validated = $request->validate($rule, $messages);
            $userUpdate = users::findOrFail($request->id);


            $file_name_users = $userUpdate->image;

            if(!empty($request->image))
            {
                $image = $request->file('image');
                $file_name_users = $image->getClientOriginalName();
                //حذف الصورة القديمة
                Storage::disk('public_uploads_users')->deleteDirectory($userUpdate->phone);
                $imageUser = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/users/'.$request->phone), $imageUser);
            }
            //التشييك على ان كان هناك قيمة كاش باك مرسلة ام لا
            if(isset($request->cashback) && !empty($request->cashback))
            {
                $cachback = $request->cashback;
            }
            else
            {
                $cachback = Null;
            }

            if(empty($request->password))
            {
                $newPassword = decrypt($userUpdate->password);
            }else
                {
                    $newPassword = $request->password;
                }

            $userUpdate->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($newPassword),
                'cashback' => $cachback,
                'image' => $file_name_users,
                'balance' => $request->balance,
                'isActive' => $request->isActive,
            ]);

            toastr()->success("تم تعديل المستخدم  بنجاح", "رسالة نجاح ");
            return redirect('/users');
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
            $users = users::findOrFail($request->id);
            Storage::disk('public_uploads_users')->deleteDirectory($users->phone);
            $users->delete();
            toastr()->error('تم حذف المستخدم بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
