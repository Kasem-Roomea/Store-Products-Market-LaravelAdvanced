<?php

namespace App\Imports;

use App\Models\categories;
use App\Models\stores;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new categories([
            'nameAr'     => $row[0],
            'nameEn'    => $row[1],
            'categories_id'    => categories::select('id')->where('nameAr',$row[2])->first()->id??null,
            'stores_id'    => stores::select('id')->where('name',$row[3])->first()->id??null,
            'orderNum'    => $row[4],
            'discount'    => floatval($row[5])??'',
            'isActive'    => $row[6]??1,
            'createdAt'    => now(),
        ]);
    }
}
