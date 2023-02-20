<?php

namespace App\Http\Controllers\products;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\images;
use App\Models\products;
use App\Models\regions;
use App\Models\stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = products::paginate(25);
            $stores = stores::all();
            $categories = categories::whereNotNull('categories_id')->get(['id', 'nameAr', 'nameEn']);
            return view('products.products', compact('products', 'stores', 'categories'));
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
        try
        {
        $rule = [
            "ID_" => "required|unique:products,ID_",
            "nameAr" => "required|min:3",
            "nameEn" => "required|min:3",
            "descriptionAr" => "min:3",
            "descriptionEn" => "min:3",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
            "image" => "required",
            "categories_id" => "required",
            "stores_id" => "required",
        ];

            $messages = [

            "ID_.required" => "يجب ادخال الباركود",
            "ID_.unique" => "يجب ادخال باركود مختلف",

            "nameAr.required" => "يجب ادخال الاسم بالعربي",
            "nameAr.min" => "يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

            "nameEn.required" => "يجب ادخال الاسم بالانجليزي",
            "nameEn.min" => "يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

            "descriptionAr.required" => "يجب ادخال الوصف بالعربي",
            "descriptionAr.min" => "يجب ان لا يقل الوصف بالعربي عن 3 حروف ",

            "descriptionEn.required" => "يجب ادخال الوصف بالانجليزي",
            "descriptionEn.min" => "يجب ان لا يقل الوصف بالعربي عن 3 حروف ",

            "price.required" => "يجب ادخال السعر",
            "price.numeric" => "يجب ادخال السعر بشكل صحيح ",

            "quantity.required" => "يجب ادخال الكمية ",
            "quantity.numeric" => "يجب ادخال الكمية بشكل صحيح ",

            "image.required" => "يجب إدخال الصور",


            "categories_id.required" => "يجب ادخال القسم ",
            "stores_id.required" => "يجب ادخال المتجر ",
        ];
            $validated = $request->validate($rule, $messages);


            $start = null;
            $end = null;
            $discount = null;
            $free = 0;
            $file_name = Null;

            if($request->offers == 'on')
             {
                $start = $request->startAt;
                $end = $request->endAt;
                $discount = $request->discount;
            }

            if($request->isFreeDelivered == 'on')
            {
                $free = 1;
            }
            //التشييك على أضافة صورة
            if (isset($request->image) && !empty($request->image))
            {
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
            }

            $product = products::create([
                "ID_" => $request->ID_,
                'nameAr' => $request->nameAr,
                'nameEn' => $request->nameEn,
                'descriptionAr' => $request->descriptionAr,
                'descriptionEn' => $request->descriptionEn,
                'price' => $request->price,
                'quantity' => $request->quantity,
                "categories_id" => $request->categories_id,
                "stores_id" => $request->stores_id,
                "discount" => $discount,
                "start_at_offer" =>$start,
                "end_at_offer" => $end,
                "isFreeDelivered" =>$free,
                "createdAt" =>now(),
                "points" => $request->points ?? 0
                ]);

            //أضافة الصورة بجدول الصور
                if ( $file_name != Null)
                {
                    $lastId = products::select('id')->orderby('id' , 'DESC')->first();
                    $imageProduct = $request->image->getClientOriginalName();
                    $request->image->move(public_path('Attachments/products/'.$request->ID_), $imageProduct);

                    $image = images::create([
                        "image" =>$file_name,
                        "createdAt" =>now(),
                        "products_id" =>$lastId->id,
                    ]);

                }

            toastr()->success("تم أضافة منتج جديد بنجاح", "رسالة نجاح ");
            return redirect('/products');
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
        try
        {
            $rule = [
                "ID_" => "required|unique:products,ID_," . $request->id,
                "nameAr" => "required|min:3",
                "nameEn" => "required|min:3",
                "descriptionAr" => "min:3",
                "descriptionEn" => "min:3",
                "price" => "required|numeric",
                "quantity" => "required|numeric",
                "categories_id" => "required",
                "stores_id" => "required",
            ];

            $messages = [

                "ID_.required" => "يجب ادخال الباركود",
                "ID_.unique" => "يجب ادخال باركود مختلف",

                "nameAr.required" => "يجب ادخال الاسم بالعربي",
                "nameAr.min" => "يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

                "nameEn.required" => "يجب ادخال الاسم بالانجليزي",
                "nameEn.min" => "يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

                "descriptionAr.min" => "يجب ان لا يقل الوصف بالعربي عن 3 حروف ",

                "descriptionEn.min" => "يجب ان لا يقل الوصف بالعربي عن 3 حروف ",

                "price.required" => "يجب ادخال السعر",
                "price.numeric" => "يجب ادخال السعر بشكل صحيح ",

                "quantity.required" => "يجب ادخال الكمية ",
                "quantity.numeric" => "يجب ادخال الكمية بشكل صحيح ",

                "categories_id.required" => "يجب ادخال القسم ",
                "stores_id.required" => "يجب ادخال المتجر ",
            ];
            $validated = $request->validate($rule, $messages);
            $idUpdate = products::findOrFail($request->id);
            $idUpdateImage = images::where('products_id',$request->id)->first();

            $start = null;
            $end = null;
            $discount = null;
            $free = 0;

            if($request->offers == 'on')
            {
                $start = $request->startAt;
                $end = $request->endAt;
                $discount = $request->discount;
            }

            if($request->isFreeDelivered == 'on')
            {
                $free = 1;
            }



                if (isset($request->image) && !empty($request->image))
                {
                    $image = $request->file('image');
                    $file_name = $image->getClientOriginalName();
                    Storage::disk('public_uploads_products')->deleteDirectory($idUpdate->ID_);
                    $imageProduct = $request->image->getClientOriginalName();
                    $request->image->move(public_path('Attachments/products/'.$request->ID_), $imageProduct);
                    $idUpdateImage->update([
                        "image" =>$file_name,
                    ]);
                }



            $idUpdate->update([
                "ID_" => $request->ID_,
                'nameAr' => $request->nameAr,
                'nameEn' => $request->nameEn,
                'descriptionAr' => $request->descriptionAr,
                'descriptionEn' => $request->descriptionEn,
                'price' => $request->price,
                'quantity' => $request->quantity,
                "categories_id" => $request->categories_id,
                "stores_id" => $request->stores_id,
                "discount" => $discount,
                "start_at_offer" =>$start,
                "end_at_offer" => $end,
                "isFreeDelivered" =>$free,
                "isActive" =>$request->isActive,
                "points" => $request->points ?? 0
            ]);

            //أضافة الصورة بجدول الصور


            toastr()->success("تم تعديل المنتج بنجاح", "رسالة نجاح ");
            return redirect('/products');
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
            $products = products::findOrFail($request->id);
            $productsImage = images::where('products_id',$request->id)->first();
            Storage::disk('public_uploads_products')->deleteDirectory($products->ID_);
            $products->delete();
            if(!empty($productsImage))
            {
                $productsImage->delete();
            }

            toastr()->error('تم حذف المنتج بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}
