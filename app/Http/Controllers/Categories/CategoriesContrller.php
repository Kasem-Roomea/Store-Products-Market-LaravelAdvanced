<?php

namespace App\Http\Controllers\Categories;

use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use App\Imports\CategoriesImport;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesContrller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = categories::whereNull('categories_id')->get();
            return view('Categories.Categories', compact('categories'));
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
                //'pic.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ];
            $rule = [
                'Name' => 'required|unique:categories,nameAr',
                'Name_en' => 'required',
                'orderNum' => 'required|unique:categories,orderNum',
                // 'pic' => 'mimes:pdf,jpeg,png,jpg',
            ];
            $validated = $request->validate($rule, $messages);
            $file_name = Null;
            //التشييك على أضافة صورة
            if (isset($request->pic) && !empty($request->pic)) {
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
            }


            categories::create([
                'nameAr' => $request->Name,
                'nameEn' => $request->Name_en,
                'orderNum' => $request->orderNum,
                'image' => $file_name,
            ]);


            if ( $file_name != Null)
            {
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/categories/'.$request->orderNum), $imageName);
            }


            toastr()->success("تم أضافة القسم بنجاح", "رسالة نجاح ");
            return redirect('/Categories');
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
                'Name.required' => 'أسم القسم مطلوب',
                'Name.unique' => 'أسم القسم موجود مسبقا',
                'Name_en.required' => 'أسم القسم مطلوب',
                'orderNum.required' => 'ترتيب القسم مطلوب ',
                'orderNum.unique' => 'ترتيب القسم موجود مسبقا ',
            ];
            $rule = [
                'Name_en' => 'required',
                'Name' => 'required|unique:categories,nameAr,'.$request->id,
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
                'orderNum' => $request->orderNum,
                'isActive' => $request->status,
                'image' => $file_name,
            ]);

            toastr()->success('تم التعديل بنجاح', "رسالة نجاح");
            return redirect('/Categories');
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
            $Products = categories::findOrFail($request->id);

            //delete image
            Storage::disk('public_uploads_categories')->deleteDirectory($Products->orderNum);

            $Products->delete();
            toastr()->error('تم حذف القسم بنجاح', 'رسالة نجاح');
            return back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function export()
    {
        try {
            return Excel::download(new CategoriesExport, 'Categories.xlsx');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function import(Request $request)
    {
        try {
            Excel::import(new CategoriesImport, $request->file('Categories_file'));
            toastr()->success("تم أضافة الأقسام بنجاح", "رسالة نجاح ");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
