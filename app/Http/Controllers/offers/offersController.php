<?php

namespace App\Http\Controllers\offers;

use App\Http\Controllers\Controller;
use App\Models\offers;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class offersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = offers::all();
        $products = products::get(['id' , 'nameAr' , 'nameEn']);
        return view('offers.offers' , compact('offers' , 'products'));
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
        try{
        $rule=[
            "discount"     =>"required|numeric",
            "products_id"    =>"required",
            'startAt' =>"required|after:".Carbon::parse("now")->subDay(1)->format("Y-m-d"),
            'endAt' =>"required|after:startAt",
        ];

        $messages=[

            "discount.required"     =>"يجب ادخال الخصم ",
            "discount.numeric"     =>"يجب ادخال رقم ",

            "startAt.required" =>"يجب ادخال تاريخ بداية الاعلان ",
            "startAt.after" =>"يجب أن يكون تاريخ بداية الاعلان اكبر من تاريخ اليوم ",

            "endAt.required" =>"يجب ادخال تاريخ إنتهاء الاعلان ",
            "endAt.after" =>"يجب أن يكون تاريخ انتهاء الاعلان اكبر من تاريخ البداية ",

            "products_id.required" =>"يجب ادخال المنتج",
        ];
        $validated = $request->validate($rule, $messages);
        $offer = offers::create([
            "discount" => $request->discount,
            'startAt' => $request->startAt,
            'endAt' => $request->endAt,
            'products_id' => $request->products_id,
            'created_at' => now(),
        ]);


        toastr()->success("تم أضافة عرض جديد بنجاح", "رسالة نجاح ");
        return redirect('/offers');
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
        try{
            $rule=[
                "discount"     =>"required|numeric",
                "products_id"    =>"required",
                'startAt' =>"required|after:".Carbon::parse("now")->subDay(1)->format("Y-m-d"),
                'endAt' =>"required|after:startAt",
            ];

            $messages=[

                "discount.required"     =>"يجب ادخال الخصم ",
                "discount.numeric"     =>"يجب ادخال رقم ",

                "startAt.required" =>"يجب ادخال تاريخ بداية الاعلان ",
                "startAt.after" =>"يجب أن يكون تاريخ بداية الاعلان اكبر من تاريخ اليوم ",

                "endAt.required" =>"يجب ادخال تاريخ إنتهاء الاعلان ",
                "endAt.after" =>"يجب أن يكون تاريخ انتهاء الاعلان اكبر من تاريخ البداية ",

                "products_id.required" =>"يجب ادخال المنتج",
            ];
            $validated = $request->validate($rule, $messages);
            $offerUpdate = offers::findOrFail($request->id);
            $offerUpdate->update([
                "discount" => $request->discount,
                'startAt' => $request->startAt,
                'endAt' => $request->endAt,
                'products_id' => $request->products_id,
                'isActive' => $request->isActive,
            ]);


            toastr()->success("تم تعديل العرض بنجاح", "رسالة نجاح ");
            return redirect('/offers');
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
            $offer = offers::findOrFail($request->id);
            $offer->delete();
            toastr()->error('تم حذف العرض بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
