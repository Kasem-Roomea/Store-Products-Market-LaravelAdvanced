<?php

namespace App\Http\Controllers\daysKm;

use App\Http\Controllers\Controller;
use App\Models\days_list;
use Illuminate\Http\Request;

class daysKmController extends Controller
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
            $daysKm = days_list::all();
            return view('daysKm.daysKm' , compact('daysKm'));
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
            'startKm.required' => ' بداية المسافة مطلوب',
            'startKm.numeric' => 'بداية المسافة  يجي ان يكون رقم',
            'endKm.required' => ' نهاية المسافة مطلوب',
            'endKm.numeric' => 'نهاية المسافة يجب ان يكون رقم',
            'endKm.min' => 'نهاية المسافة يجب ان تكون أكثر من بداية الطريق',
            'Time.required' => ' الوقت مطلوب ',
            'Time.numeric' => 'الوقت يجب ان يكون رقم',
        ];
        $rule = [
            'startKm' => 'required|numeric',
            'endKm' => 'required|numeric|min:'.intval($request->startKm),
            'Time' => 'required|numeric',
        ];
        $validated = $request->validate($rule, $messages);


        days_list::create([
            'startKm' => $request->startKm,
            'endKm' => $request->endKm,
            'days' => $request->Time,
        ]);

        toastr()->success("تم أضافة وقت التوصيل بنجاخ بنجاح", "رسالة نجاح ");
        return redirect('/daysKm');
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
                'startKm.required' => ' بداية المسافة مطلوب',
                'startKm.numeric' => 'بداية المسافة  يجب ان يكون رقم',
                'endKm.required' => ' نهاية المسافة مطلوب',
                'endKm.numeric' => 'نهاية المسافة يجب ان يكون رقم',
                'endKm.min' => 'نهاية المسافة يجب ان تكون أكثر من بداية الطريق',
                'Time.required' => ' الوقت مطلوب ',
                'Time.numeric' => 'الوقت يجب ان يكون رقم',
            ];
            $rule = [
                'startKm' => 'required|numeric',
                'endKm' => 'required|numeric|min:'.intval($request->startKm),
                'Time' => 'required|numeric',
            ];
            $validated = $request->validate($rule, $messages);
            $days = days_list::find($request->id);
            $days->update([
                'startKm' => $request->startKm,
                'endKm' => $request->endKm,
                'days' => $request->Time,
            ]);

            toastr()->success("تم تعديل وقت التوصيل  بنجاح", "رسالة نجاح ");
            return redirect('/daysKm');
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
            $days = days_list::findOrFail($request->id);
            $days->delete();
            toastr()->error('تم حذف وقت التوصيل بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
