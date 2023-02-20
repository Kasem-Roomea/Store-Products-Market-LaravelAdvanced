<?php

namespace App\Http\Controllers\Categories;

use App\Exports\CategoriesPartExport;
use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class Categories_part extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories_part = categories::whereNotNull('categories_id')->get();
            $categories = categories::whereNull('categories_id')->get();
            return view('Categories.Categories_part', compact('categories', 'categories_part'));
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
                    'Name.required' => 'أسم القسم مطلوب',
                    'Name.unique' => 'أسم القسم موجود مسبقا',
                    'Name_en.required' => 'أسم القسم مطلوب',
                    'orderNum.required' => 'ترتيب القسم مطلوب ',
                    'orderNum.unique' => 'ترتيب القسم موجود مسبقا ',
                    'Categories_id.required' => 'القسم الرئيسي مطلوب ',
                    //'pic.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
                ];
                $rule = [
                    'Name' => 'required|unique:categories,nameAr',
                    'Name_en' => 'required',
                    'orderNum' => 'required|unique:categories,orderNum',
                    'Categories_id' => 'required',
                    // 'pic' => 'mimes:pdf,jpeg,png,jpg',
                ];
                $validated = $request->validate($rule, $messages);

                 $file_name = Null;
                 //التشييك على أضافة صورة
                if (isset($request->pic) && !empty($request->pic))
                {
                    $image = $request->file('pic');
                    $file_name = $image->getClientOriginalName();
                }
                $id_cat = intval($request->Categories_id);
                categories::create([
                    'nameAr' => $request->Name,
                    'nameEn' => $request->Name_en,
                    'categories_id' => $id_cat,
                    'orderNum' => $request->orderNum,
                    'image' => $file_name,
                ]);

            if ( $file_name != Null)
            {
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/categories/'.$request->orderNum), $imageName);
            }

                toastr()->success("تم أضافة القسم بنجاح", "رسالة نجاح ");
                return back();
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
            $id = $request->id;
            $messages = [
                'Name.required' => 'أسم القسم مطلوب',
                'Name.unique' => 'أسم القسم موجود مسبقا',
                'Name_en.required' => 'أسم القسم مطلوب',
                'orderNum.required' => 'ترتيب القسم مطلوب ',
                'orderNum.unique' => 'ترتيب القسم موجود مسبقا ',
                'Categories_id.required' => 'القسم الرئيسي مطلوب ',
            ];
            $rule = [
                'Name' => 'required|unique:categories,nameAr,'.$id,
                'Name_en' => 'required',
                'Categories_id' => 'required',
                'orderNum' => 'required|unique:categories,orderNum,'.$id,
                'status' => 'required',
            ];
            $validated = $request->validate($rule, $messages);


            $categorie = categories::find($request->id);

            $file_name = $categorie->image;
            //التشييك على أضافة صورة
            if (isset($request->pic) && !empty($request->pic))
            {
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                Storage::disk('public_uploads_categories')->deleteDirectory($categorie->orderNum);
                $imageCategories = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/categories/' . $categorie->orderNum), $imageCategories);
            }


            $categorie->update([
                'nameAr' => $request->Name,
                'nameEn' => $request->Name_en,
                'categories_id' => intval($request->Categories_id),
                'orderNum' => $request->orderNum,
                'isActive' => $request->status,
                'image' => $file_name,
            ]);



            toastr()->success('تم التعديل بنجاح', "رسالة نجاح");
            return back();
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
        try {
            $categorie = categories::findOrFail($request->id);

            //delete image
            Storage::disk('public_uploads_categories')->deleteDirectory($categorie->orderNum);

            // Delete
            $categorie->delete();
            toastr()->error('تم الحذف بنجاح', "رسالة نجاح");
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function export()
    {
        try
        {
            return Excel::download(new CategoriesPartExport, 'CategoriesPart.xlsx',Maatwebsite\Excel\Excel::XLSX);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



}
