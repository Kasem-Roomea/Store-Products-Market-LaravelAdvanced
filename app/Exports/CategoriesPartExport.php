<?php

namespace App\Exports;

use App\Models\categories;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoriesPartExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $one =  categories::whereNotNull('categories_id')->get(['nameAr','nameEn','categories_id', 'stores_id', 'orderNum' ,'discount','isActive','image', 'createdAt']);
       foreach ($one as $o)
       {
           $o->categories_id = $o->category->nameAr??'';
           $o->stores_id = $o->store->name??'';
           $o->image =public_path().'/Attachments/categories/'.$o->image??'';

       }
        return $one;
    }
}
