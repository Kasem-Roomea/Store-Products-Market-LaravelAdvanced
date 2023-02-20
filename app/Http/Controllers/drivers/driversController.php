<?php

namespace App\Http\Controllers\drivers;

use App\Http\Controllers\Controller;
use App\Models\delivery_methods;
use App\Models\drivers;
use App\Models\vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class driversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = drivers::get();
        $vehicle = vehicles::all();
        $delivery = delivery_methods::all();
        return view('drivers.drivers' , compact('drivers' ,'vehicle' , 'delivery'));
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
                'name.required' => 'الاسم مطلوب',
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'رقم الهاتف يجب ان يكون ارقام',
                'phone.unique' => 'رقم الهاتف يجب ان يكون فريد',
                'email.required' => ' يجب ادخال البريد الالكتروني',
                'email.email' => 'صيغة البريد الالكتروني خاطئة',
                'email.unique' => ' البريد الكتروني موجود مسبقا ',
                'balance.required' => 'الرصيد مطلوب',
                'balance.numeric' => 'الرصيد يجب ان يكون ارقام ',
                'fees.required' => 'الرسوم مطلوبة',
                'fees.numeric' => 'الرسوم يجب ان تكون ارقام',
                'delivery.required' => 'نوع التوصيل مطلوب',
            ];
            $rule = [
                'name' => 'required',
                'email' => 'required|email|unique:drivers,email',
                'phone' => 'required|numeric|unique:drivers,phone',
                'balance' => 'required|numeric',
                'fees' => 'required|numeric',
                'delivery' => 'required',
            ];
            $validated = $request->validate($rule, $messages);

            $image1 = $request->file('personal');
            $file_name_personal = $image1->getClientOriginalName();

            $image2 = $request->file('idPhoto');
            $file_name_id = $image2->getClientOriginalName();

            $image3 = $request->file('licenseDriver');
            $file_name_licenseDriver = $image3->getClientOriginalName();

            $image4 = $request->file('carPhoto');
            $file_name_carPhoto = $image4->getClientOriginalName();

            $image5 = $request->file('licenseCar');
            $file_name_licenseCar = $image5->getClientOriginalName();

            drivers::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'apiToken'=>null,
                'vehicles_id' => intval($request->vehicle),
                'licenseNumber' => $request->licenseNumber,
                'model' => $request->model,
                'balance' => $request->balance,
                'fees' => $request->fees,
                'delivery_methods_id' =>intval($request->delivery),
                'image' => $file_name_personal,
                'IdPhoto' => $file_name_id,
                'driverLicenseImage' => $file_name_licenseDriver,
                'carLicenseImage' => $file_name_licenseCar,
                'carImage' => $file_name_carPhoto,
                'createdAt' => now(),
            ]);
            $imagePersonal = $request->personal->getClientOriginalName();
            $request->personal->move(public_path('Attachments/drivers/'.$request->phone), $imagePersonal);

            $imageIdPhoto = $request->idPhoto->getClientOriginalName();
            $request->idPhoto->move(public_path('Attachments/drivers/'.$request->phone), $imageIdPhoto);

            $imageLicenseDriver = $request->licenseDriver->getClientOriginalName();
            $request->licenseDriver->move(public_path('Attachments/drivers/'.$request->phone), $imageLicenseDriver);

            $imageCarPhoto = $request->carPhoto->getClientOriginalName();
            $request->carPhoto->move(public_path('Attachments/drivers/'.$request->phone), $imageCarPhoto);

            $imageLicenseCar = $request->licenseCar->getClientOriginalName();
            $request->licenseCar->move(public_path('Attachments/drivers/'.$request->phone), $imageLicenseCar);

            toastr()->success("تم أضافة السائق بنجاح", "رسالة نجاح ");
            return redirect('/drivers');
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
                'name.required' => 'الاسم مطلوب',
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'رقم الهاتف يجب ان يكون ارقام',
                'phone.unique' => 'رقم الهاتف يجب ان يكون فريد',
                'email.required' => ' يجب ادخال البريد الالكتروني',
                'email.email' => 'صيغة البريد الالكتروني خاطئة',
                'email.unique' => ' البريد الكتروني موجود مسبقا ',
                'balance.required' => 'الرصيد مطلوب',
                'balance.numeric' => 'الرصيد يجب ان يكون ارقام ',
                'fees.required' => 'الرسوم مطلوبة',
                'fees.numeric' => 'الرسوم يجب ان تكون ارقام',
                //'delivery_methods_id.required' => 'نوع التوصيل مطلوب',
            ];
            $rule = [
                'name' => 'required',
                'email' => 'required|email|unique:drivers,email,'.$request->id,
                'phone' => 'required|numeric|unique:drivers,phone,'.$request->id,
                'balance' => 'required|numeric',
                'fees' => 'required|numeric',
                //'delivery_methods_id' => 'required',
            ];
            $validated = $request->validate($rule, $messages);
            $driverUpdate = drivers::findOrFail($request->id);


            $file_name_personal = $driverUpdate->image;
            $file_name_id = $driverUpdate->IdPhoto;
            $file_name_licenseDriver = $driverUpdate->driverLicenseImage;
            $file_name_carPhoto = $driverUpdate->carImage;
            $file_name_licenseCar = $driverUpdate->carLicenseImage;

            //images update
            if (isset($request->personal) && !empty($request->personal))
            {
                $image1 = $request->file('personal');
                $file_name_personal = $image1->getClientOriginalName();
                Storage::disk('public_uploads_drivers')->delete($driverUpdate->phone.'/'.$driverUpdate->image);
                $imagePersonal = $request->personal->getClientOriginalName();
                $request->personal->move(public_path('Attachments/drivers/'.$request->phone), $imagePersonal);
            }
            if (isset($request->idPhoto) && !empty($request->idPhoto))
            {
                $image2 = $request->file('idPhoto');
                $file_name_id = $image2->getClientOriginalName();
                Storage::disk('public_uploads_drivers')->delete($driverUpdate->phone.'/'.$driverUpdate->IdPhoto);
                $imageIdPhoto = $request->idPhoto->getClientOriginalName();
                $request->idPhoto->move(public_path('Attachments/drivers/'.$request->phone), $imageIdPhoto);
            }
            if (isset($request->licenseDriver) && !empty($request->licenseDriver))
            {
                $image3 = $request->file('licenseDriver');
                $file_name_licenseDriver = $image3->getClientOriginalName();
                Storage::disk('public_uploads_drivers')->delete($driverUpdate->phone.'/'.$driverUpdate->driverLicenseImage);
                $imageLicenseDriver = $request->licenseDriver->getClientOriginalName();
                $request->licenseDriver->move(public_path('Attachments/drivers/'.$request->phone), $imageLicenseDriver);
            }
            if (isset($request->carPhoto) && !empty($request->carPhoto))
            {
                $image4 = $request->file('carPhoto');
                $file_name_carPhoto = $image4->getClientOriginalName();
                Storage::disk('public_uploads_drivers')->delete($driverUpdate->phone.'/'.$driverUpdate->carImage);
                $imageCarPhoto = $request->carPhoto->getClientOriginalName();
                $request->carPhoto->move(public_path('Attachments/drivers/'.$request->phone), $imageCarPhoto);
            }
            if (isset($request->licenseCar) && !empty($request->licenseCar))
            {
                $image5 = $request->file('licenseCar');
                $file_name_licenseCar = $image5->getClientOriginalName();
                Storage::disk('public_uploads_drivers')->delete($driverUpdate->phone.'/'.$driverUpdate->carLicenseImage);
                $imageLicenseCar = $request->licenseCar->getClientOriginalName();
                $request->licenseCar->move(public_path('Attachments/drivers/'.$request->phone), $imageLicenseCar);
            }

            $delivery = intval($request->delivery_methods_id);
               $car =  intval($request->vehicles_id);

            if(empty($request->password))
            {
                $newPassword = decrypt($driverUpdate->password);
            }else
            {
                $newPassword = $request->password;
            }
            $driverUpdate->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'isActive' => intval($request->isActive),
                'isApproved' => intval($request->isVerified),
                'password' => bcrypt($newPassword),
                'vehicles_id' => $car,
                'licenseNumber' => $request->licenseNumber,
                'model' => $request->model,
                'balance' => $request->balance,
                'fees' => $request->fees,
                'delivery_methods_id' =>$delivery,
                'image' =>$file_name_personal,
                'IdPhoto' =>$file_name_id,
                'driverLicenseImage' =>$file_name_licenseDriver,
                'carImage' =>$file_name_carPhoto,
                'carLicenseImage' =>$file_name_licenseCar,
            ]);

            toastr()->success("تم تعديل معلومات السائق بنجاح", "رسالة نجاح ");
            return redirect('/drivers');
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
            $driver = drivers::findOrFail($request->id);
            Storage::disk('public_uploads_drivers')->deleteDirectory($driver->phone);
            $driver->delete();
            toastr()->error('تم حذف السائق بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
