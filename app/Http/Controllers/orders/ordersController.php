<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;

class ordersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = orders::paginate(25);
            return view('Orders.Orders', compact('orders'));
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
        //
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
                'status.required' => '  حالة الطلب مطلوبة ',
            ];
            $rule = [
                'status' => 'required',
            ];
            $validated = $request->validate($rule, $messages);


            $order = orders::find($request->id);
            $order->update([
                'status' => $request->status,
            ]);

            toastr()->success("تم تعديل  حالة الطلب بنجاح", "رسالة نجاح ");
            return redirect('/orders');
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
            if($request->id == 'all')
            {
                    $orders = orders::all();
                    foreach ($orders as $o)
                    {
                        $o->forceDelete();
                    }
                toastr()->error('تم حذف جميع الطلبات بنجاح', 'رسالة نجاح');
                return back();
            }

            else
                {
                    $order = orders::findOrFail($request->id);
                    $order->delete();
                    toastr()->error('تم حذف الطلب بنجاح', 'رسالة نجاح');
                    return back();
                }

        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public static function getRecordInfo($id)
    {
        $records =  orders::find($id)->carts;
        return view("orders.orderTableInfo",compact('records'));
    }
}
