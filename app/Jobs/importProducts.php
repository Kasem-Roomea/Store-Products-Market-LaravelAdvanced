<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;
use App\Models\brands;
use App\Models\categories;
use App\Models\sections;
use App\Models\images;

use App\Models\products as model;

use Intervention\Image\ImageManagerStatic as Image;

class importProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels ,Batchable;


    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        
        foreach ($this->data as $data) {
            if(!isset($data['ID_'])) return null;
            $mainCategory=self::mainCategory($data);
            $subCategory= self::subCategory($data,$mainCategory);

            $brand= self::brand($data);
            $section= self::section($data);
            $productData=
            model::updateOrCreate(['ID_'=>$data['ID_']],[
                'price'=>$data['Price'],
                'product_price'=>$data['Old Price'],
                'nameAr'=>$data['الاسم'],
                'nameEn'=>$data['Name en'],
                'quantity'=>(int)($data['quantity']??10000),
                'isActive'=>1,
                'product_type'=>$data['Product type'],
                'descriptionAr'=>$data['Content'],
                'descriptionEn'=>$data['Content'],
                'categories_id'=>$subCategory->id,
                'brands_id'=>$brand->id,
                'sections_id'=>$section->id,
                'createdAt'=>now()
            ]);
            if(isset($data[' Image File'])){
                $pathInFile= explode("\images\\",$data[' Image File'])[1];
                $image= "/uploads/products/{$pathInFile}";
                images::updateOrCreate(['products_id'=>$product->id],['image'=>$image]);
            }
        }
    }
    static function mainCategory($data)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['Category']],[
                'nameEn'=>$data['Category'],
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }
    static function subCategory($data,$mainCategory)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['Sub category'],'categories_id'=>$mainCategory->id],[
                'nameEn'=>$data['Category'],
                'categories_id'=>$mainCategory->id,
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }

    static function brand($data)
    {
        return 
            brands::firstOrCreate(['nameAr'=>$data['Brand']],[
                'nameAr'=>$data['Brand'],
                'nameEn'=>$data['Brand'],
                'createdAt'=>now()
            ]);
    }
    static function section($data)
    {
        return 
            sections::firstOrCreate(['nameAr'=>$data['Section']],[
                'nameAr'=>$data['Section'],
                'nameEn'=>$data['Section'],
                'created_at'=>now()
            ]);
    }
}
