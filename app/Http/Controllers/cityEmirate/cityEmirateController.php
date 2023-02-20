<?php

namespace App\Http\Controllers\cityEmirate;

use App\Http\Controllers\Controller;
use App\Models\regions;
use Illuminate\Http\Request;

class cityEmirateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $region = regions::all();
            $emirate = regions::whereNull('regions_id')->get();
            $city = regions::where('type' , "city")->get();
            return view('region.region' , compact('region' , 'emirate' , 'city'));
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
                'nameAr.required' => ' الاسم بالعربي  مطلوب',
                'nameEn.required' => '  الاسم بالانكليزي مطلوب',
            ];
            $rule = [
                'nameAr' => 'required',
                'nameEn' => 'required',
            ];
            $validated = $request->validate($rule, $messages);

            if($request->rdio=='emirate')
            {
                regions::create([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'type' => $request->rdio,
                    'isActive' => $request->Active,
                    'createdAt' => now(),
                ]);

                toastr()->success("تم الأضافة الأمارة بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }
            elseif($request->rdio=='city')
            {
                regions::create([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'regions_id' => intval($request->emirate),
                    'type' => $request->rdio,
                    'isActive' => $request->Active,
                    'createdAt' => now(),
                ]);

                toastr()->success("تم أضافة المدينة بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }
            else
            {
                regions::create([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'regions_id' => intval($request->city),
                    'type' => $request->rdio,
                    'isActive' => $request->Active,
                    'createdAt' => now(),
                ]);

                toastr()->success("تم أضافة المنطقة بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }

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
    public function update(Request $request, $id)
    {

        try {
            $messages = [
                'nameAr.required' => ' الاسم بالعربي  مطلوب',
                'nameEn.required' => '  الاسم بالانكليزي مطلوب',
            ];
            $rule = [
                'nameAr' => 'required',
                'nameEn' => 'required',
            ];
            $validated = $request->validate($rule, $messages);

            $region = regions::find($request->id);

            if(isset($request->city))
            {
                $region->update([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'regions_id' => intval($request->city),
                    'isActive' => $request->Active,
                ]);
                toastr()->success("تم تعديل المنطقة بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }
            elseif(isset($request->emirate))
            {
                $region->update([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'regions_id' => intval($request->emirate),
                    'isActive' => $request->Active,
                ]);
                toastr()->success("تم تعديل المدينة بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }
            else
            {
                $region->update([
                    'nameAr' => $request->nameAr,
                    'nameEn' => $request->nameEn,
                    'isActive' => $request->Active,
                ]);
                toastr()->success("تم التعديل  بنجاح", "رسالة نجاح ");
                return redirect('/cityEmirate');
            }

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
            $region = regions::findOrFail($request->id);
            $region->delete();
            toastr()->error('تم الحذف بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
