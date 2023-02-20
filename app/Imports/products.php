<?php

namespace App\Imports;

use App\Models\store\products as model;
use App\Models\store\categories;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Http\Controllers\Controller; 

class products implements ToModel
{
    public function model(array $row)
    {
        // if($row[3] != 'القسم'){
        //     $category = categories::where('name',$row[3])->first();
        //     if(!$category){
        //         $category= categories::createUpdate([
        //             'name'=>$row[3],
        //         ]);
        //     }
        model::updateOrCreate(['ID_'=>$row[0] ],[
            'nameAr'=>$row[1],
            'nameEn'=>$row[2],
            'descriptionAr'=>$row[6],
            'descriptionEn'=>$row[6],
            'quantity'=>$row[4],
            'price'=>$row[3],
            'product_price'=>$row[4],
            'quantity'=>$row[5],
        ]);
        // }
    }
}