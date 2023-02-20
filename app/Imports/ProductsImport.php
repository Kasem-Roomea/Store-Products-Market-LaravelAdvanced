<?php

namespace App\Imports;

use App\Models\categories;
use App\Models\products;
use App\Models\stores;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        return new products([
            'ID_'     => $row[0],
            'nameAr'     => $row[1],
            'nameEn'    => $row[2],
            'descriptionAr'    => $row[3],
            'descriptionEn'    => $row[4],
            'price'    => $row[5]??0,
            'quantity'    => $row[6]??0,
            'categories_id'    => categories::select('id')->where('nameAr',$row[7])->first()->id,
            'stores_id'    => stores::select('id')->where('name',$row[8])->first()->id,
            'discount'    => $row[9]??null,
            'start_at_offer'    => $row[10],
            'end_at_offer'    => $row[11],
            'isFreeDelivered'    => $row[12]??0,
            'isActive'    => $row[13]??1,
            'createdAt'    => now(),
        ]);
    }
}
