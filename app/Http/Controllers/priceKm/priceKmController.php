<?php

namespace App\Http\Controllers\priceKm;

use App\Http\Controllers\Controller;
use App\Models\price_list;
use Illuminate\Http\Request;

class priceKmController extends Controller
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
            $priceKm = price_list::all();
            return view('PriceKm.priceKm' , compact('priceKm'));
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
                'startKm.required' => 'أسم القسم مطلوب',
                'startKm.numeric' => 'بداية المسافة  يجي ان يكون رقم',
                'endKm.required' => 'أسم القسم مطلوب',
                'endKm.min' => 'نهاية المسافة يجب ان تكون أكثر من بداية الطريق',
                'endKm.numeric' => 'نهاية المسافة يجب ان يكون رقم',
                'Price.required' => ' السعر مطلوب ',
                'Price.numeric' => ' السعر يجب ان يكون رقم',
                'minPrice.required' => ' الحد الأدنى للطلب مطلوب ',
                'minPrice.numeric' => ' الحد الادنى للطلب يجب ان يكون رقم',

            ];
            $rule = [
                'startKm' => 'required|numeric',
                'endKm' => 'required|numeric|min:'.intval($request->startKm),
                'Price' => 'required|numeric',
                'minPrice' => 'required|numeric',
            ];
            $validated = $request->validate($rule, $messages);


            price_list::create([
                'startKm' => $request->startKm,
                'endKm' => $request->endKm,
                'price' => $request->Price,
                'minPriceForOrder' => $request->minPrice,
                'createdAt' => now(),
            ]);

            toastr()->success("تم أضافة سعر التوصيل بنجاخ بنجاح", "رسالة نجاح ");
            return redirect('/priceKm');
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
                'startKm.required' => ' بداية المسافة مطلوبة',
                'startKm.numeric' => 'بداية المسافة  يجي ان يكون رقم',
                'endKm.required' => 'نهاية المسافة  مطلوبة',
                'endKm.numeric' => 'نهاية المسافة يجب ان يكون رقم',
                'endKm.min' => 'نهاية المسافة يجب ان تكون أكثر من بداية الطريق',
                'Price.required' => ' السعر مطلوب ',
                'Price.numeric' => ' السعر يجب ان يكون رقم',
                'PriceMin.required' => ' الحد الأدنى للطلب مطلوب ',
                'PriceMin.numeric' => ' الحد الادنى للطلب يجب ان يكون رقم',
            ];
            $rule = [
                'startKm' => 'required|numeric',
                'endKm' => 'required|numeric|min:'.intval($request->startKm),
                'Price' => 'required|numeric',
                'PriceMin' => 'required|numeric',
            ];
            $validated = $request->validate($rule, $messages);
            $price = price_list::find($request->id);
            $price->update([
                'startKm' => $request->startKm,
                'endKm' => $request->endKm,
                'price' => $request->Price,
                'minPriceForOrder' => $request->PriceMin,
            ]);

            toastr()->success("تم تعديل سعر التوصيل  بنجاح", "رسالة نجاح ");
            return redirect('/priceKm');
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
            $price = price_list::findOrFail($request->id);
            $price->delete();
            toastr()->error('تم حذف سعر التوصيل بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
