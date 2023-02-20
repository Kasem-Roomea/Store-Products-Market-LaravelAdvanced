<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\images ;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class uploadImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $images;
    
    public function __construct($images)
    {
        $this->images   = $images;
    }
    
    public function handle()
    {
        foreach ($this->images as $image){
            $imageRecord= new images();
            Image::make($image['path'])->save(public_path('uploads/products/').$image['name']);
            $imageRecord->image= '/uploads/products/'.$image['name'];
            $imageRecord->save();
        }
    }
}
