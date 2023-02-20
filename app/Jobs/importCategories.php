<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;
use App\Models\categories;

use App\Models\products as model;

class importCategories implements ShouldQueue
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
            $mainCategory=null;
            if($data["تابع لقسم"] != "")
                $mainCategory=self::mainCategory($data);

            // $subCategory= self::subCategory($data,$mainCategory);

            categories::updateOrCreate(['id'=>$data['id']],[
                'nameAr'=>$data['الاسم بالعربي'],
                'nameEn'=>$data['الاسم بالانجليزي'],
                'isActive'=>$data["مفعل"],
                'categories_id'=>$mainCategory->id??null,
                'createdAt'=>now()
            ]);
        }
    }
    static function mainCategory($data)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['تابع لقسم']],[
                'nameEn'=>$data['تابع لقسم'],
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }
    static function subCategory($data,$mainCategory)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['الاسم بالعربي'],'categories_id'=>$mainCategory->id],[
                'nameEn'=>$data['Category'],
                'categories_id'=>$mainCategory->id,
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }

}
