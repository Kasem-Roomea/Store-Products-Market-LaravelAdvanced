<?php

namespace App\Http\Controllers\products;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportProducts extends Controller
{
    public function export()
    {
        try {
            return Excel::download(new ProductsExport, 'Products.xlsx');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductsImport, $request->file('products_file'));
            toastr()->success("تم أضافة المنتجات بنجاح", "رسالة نجاح ");
            return redirect('/products');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
