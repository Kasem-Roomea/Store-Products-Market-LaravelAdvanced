<?php

namespace App\Http\Controllers\ads;

use App\Http\Controllers\Controller;
use App\Models\ads;
use App\Models\categories;
use App\Models\products;
use App\Models\stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class adsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = ads::all();
        $categories = categories::whereNull('categories_id')->get();
        $categories_part = categories::whereNotNull('categories_id')->get();
        $stores = stores::all();
        $products = products::get(['id' , 'nameEn' , 'nameAr']);
        return view('ads.ads' , compact('ads' , 'categories' , 'categories_part' , 'stores' , 'products'));
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
                'titleAr.required' => ' العنوان بالعربي  مطلوب',
                'titleEn.required' => '  العنوان بالانكليزي مطلوب',
                'startAt.required' => '   بداية العرض مطلوب',
                'endAt.required' => ' نهاية العرض مطلوب',
                'endAt.after' => ' نهاية العرض يجب ان يكون بعد بداية العرض',
                'screen.required' => '   مكان عرض الاعلان بالتطبيق مطلوب',
                'action.required' => ' اوجهة الاعلان بالتطبيق مطلوب',
            ];
            $rule = [
                'titleAr' => 'required',
                'titleEn' => 'required',
                'startAt' => 'required',
                'endAt' => 'required|after:startAt',
                'screen' => 'required',
                'action' => 'required',
            ];
            $validated = $request->validate($rule, $messages);
            $file_name_ads = '';
            if(!empty($request->image))
            {
                $image = $request->file('image');
                $file_name_ads = $image->getClientOriginalName();
                $imageAds = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/ads/'.$request->titleEn), $imageAds);
            }

            if($request->screen=='categories')
            {
                if($request->action=='categories')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'action' =>$request->action ,
                        'action_categories_id' =>$request->action_categories_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,
                    ]);
                }
                elseif($request->action=='stores')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'action' =>$request->action ,
                        'action_stores_id' =>$request->action_stores_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,
                    ]);
                }
                elseif ($request->action=='link')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'action' =>$request->action ,
                        'link' =>$request->link ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                elseif ($request->action == 'products')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'action' =>$request->action ,
                        'action_products_id' =>$request->action_products_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                else
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'action' =>$request->action ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
            }
            else if($request->screen=='stores')
            {
                if ($request->action == 'categories')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'action' =>$request->action ,
                        'action_categories_id' =>$request->action_categories_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                elseif ($request->action == 'stores')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'action' =>$request->action ,
                        'action_stores_id' =>$request->action_stores_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                elseif ($request->action == 'link')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'action' =>$request->action ,
                        'link' =>$request->link ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                elseif ($request->action == 'products')
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'action' =>$request->action ,
                        'action_products_id' =>$request->action_products_id ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
                else
                {
                    ads::create([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'action' =>$request->action ,
                        'createdAt'=>now(),
                        'image' => $file_name_ads,

                    ]);
                }
            }
                else //next offer and welcome
                {
                    if($request->action=='categories')
                    {
                        ads::create([
                            'titleAr' => $request->titleAr,
                            'titleEn' => $request->titleEn,
                            'startAt' => $request->startAt,
                            'endAt' => $request->endAt,
                            'screen' =>$request->screen,
                            'action' =>$request->action ,
                            'action_categories_id' =>$request->action_categories_id ,
                            'createdAt'=>now(),
                            'image' => $file_name_ads,

                        ]);
                    }
                    elseif($request->action=='stores')
                    {
                        ads::create([
                            'titleAr' => $request->titleAr,
                            'titleEn' => $request->titleEn,
                            'startAt' => $request->startAt,
                            'endAt' => $request->endAt,
                            'screen' =>$request->screen,
                            'action' =>$request->action ,
                            'action_stores_id' =>$request->action_stores_id ,
                            'createdAt'=>now(),
                            'image' => $file_name_ads,

                        ]);
                    }
                    elseif ($request->action=='link')
                    {
                        ads::create([
                            'titleAr' => $request->titleAr,
                            'titleEn' => $request->titleEn,
                            'startAt' => $request->startAt,
                            'endAt' => $request->endAt,
                            'screen' =>$request->screen,
                            'action' =>$request->action ,
                            'link' =>$request->link ,
                            'createdAt'=>now(),
                            'image' => $file_name_ads,

                        ]);
                    }
                    elseif ($request->action == 'products')
                    {
                            ads::create([
                                'titleAr' => $request->titleAr,
                                'titleEn' => $request->titleEn,
                                'startAt' => $request->startAt,
                                'endAt' => $request->endAt,
                                'screen' =>$request->screen,
                                'action' =>$request->action ,
                                'action_products_id' =>$request->action_products_id ,
                                'createdAt'=>now(),
                                'image' => $file_name_ads,
                            ]);
                        }
                    else
                    {
                            ads::create([
                                'titleAr' => $request->titleAr,
                                'titleEn' => $request->titleEn,
                                'startAt' => $request->startAt,
                                'endAt' => $request->endAt,
                                'screen' =>$request->screen,
                                'action' =>$request->action ,
                                'createdAt'=>now(),
                                'image' => $file_name_ads,
                            ]);
                        }
                }

            toastr()->success("تم أضافة الأعلان بنجاح", "رسالة نجاح ");
            return redirect('/ads');

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
                'titleAr.required' => ' العنوان بالعربي  مطلوب',
                'titleEn.required' => '  العنوان بالانكليزي مطلوب',
                'startAt.required' => '   بداية العرض مطلوب',
                'endAt.required' => ' نهاية العرض مطلوب',
                'endAt.after' => ' نهاية العرض يجب ان يكون بعد بداية العرض',
                'screen.required' => '   مكان عرض الاعلان بالتطبيق مطلوب',
                'action.required' => ' اوجهة الاعلان بالتطبيق مطلوب',
            ];
            $rule = [
                'titleAr' => 'required',
                'titleEn' => 'required',
                'startAt' => 'required',
                'endAt' => 'required|after:startAt',
                'screen' => 'required',
                'action' => 'required',
            ];
            $validated = $request->validate($rule, $messages);


            $adsUpdate = ads::findOrFail($request->id);
            $file_name_ads = $adsUpdate->image;

            if(!empty($request->image))
            {
                $image = $request->file('image');
                $file_name_ads = $image->getClientOriginalName();
                //حذف الصورة القديمة
                Storage::disk('public_uploads_ads')->deleteDirectory($adsUpdate->titleEn);
                $imageAds = $request->image->getClientOriginalName();
                $request->image->move(public_path('Attachments/ads/'.$request->titleEn), $imageAds);
            }



            if($request->screen=='categories')
            {
                if($request->action=='categories')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'stores_id'=>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_categories_id' =>$request->action_categories_id,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'link' =>null ,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,
                    ]);
                }
                elseif($request->action=='stores')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'stores_id'=>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>$request->action_stores_id ,
                        'action_categories_id' =>null,
                        'action_products_id' =>null ,
                        'link' =>null ,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,
                    ]);
                }
                elseif ($request->action=='link')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'stores_id'=>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'link' =>$request->link ,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'action_categories_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action=='products')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'stores_id'=>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>$request->action_products_id,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                else
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'categories_id' =>$request->categories_id,
                        'stores_id'=>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
            }
            else if($request->screen=='stores')
            {
                if ($request->action == 'categories')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'categories_id' =>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_categories_id' =>$request->action_categories_id ,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'link' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action == 'stores')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'categories_id' =>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>$request->action_stores_id ,
                        'link' =>null,
                        'action_products_id' =>null ,
                        'action_categories_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action == 'link')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'categories_id' =>null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'link' =>$request->link ,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'action_categories_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action=='products')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'categories_id' => null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>$request->action_products_id,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                else
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>$request->stores_id,
                        'categories_id' => null,
                        'offers_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
            }
            else //next offer and welcome
            {
                if($request->action=='categories')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>null,
                        'categories_id' => null,
                        'action' =>$request->action ,
                        'action_categories_id' =>$request->action_categories_id ,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'link' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif($request->action=='stores')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>null,
                        'categories_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>$request->action_stores_id ,
                        'link' =>null,
                        'action_products_id' =>null ,
                        'action_categories_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action=='link')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>null,
                        'categories_id' => null,
                        'action' =>$request->action ,
                        'link' =>$request->link ,
                        'action_stores_id' =>null,
                        'action_products_id' =>null ,
                        'action_categories_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,

                    ]);
                }
                elseif ($request->action=='products')
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>null,
                        'categories_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>$request->action_products_id,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,
                    ]);
                }
                else
                {
                    $adsUpdate->update([
                        'titleAr' => $request->titleAr,
                        'titleEn' => $request->titleEn,
                        'startAt' => $request->startAt,
                        'endAt' => $request->endAt,
                        'screen' =>$request->screen,
                        'stores_id' =>null,
                        'categories_id' => null,
                        'action' =>$request->action ,
                        'action_stores_id' =>null,
                        'link' =>null ,
                        'action_categories_id' =>null,
                        'action_products_id' =>null,
                        'image' => $file_name_ads,
                        'isActive'=>$request->isActive,
                    ]);
                }
            }

            toastr()->success("تم تعديل الأعلان بنجاح", "رسالة نجاح ");
            return redirect('/ads');

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
            $ads = ads::findOrFail($request->id);
            Storage::disk('public_uploads_ads')->deleteDirectory($ads->titleEn);
            $ads->delete();
            toastr()->error('تم حذف الأعلان بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
