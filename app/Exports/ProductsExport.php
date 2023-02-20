<?php

namespace App\Exports;

use App\Models\categories;
use App\Models\products;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $one =  products::get(['ID_','nameAr','nameEn','descriptionAr', 'descriptionEn', 'price' ,'quantity','categories_id','stores_id','discount','start_at_offer','end_at_offer','isFreeDelivered','isActive', 'createdAt',]);
        foreach ($one as $o)
        {
            $o->categories_id = $o->nameCategoriesProduct->nameAr??'';
            $o->stores_id = $o->nameStoresProduct->name??'';
        }
        return $one;
    }

}
