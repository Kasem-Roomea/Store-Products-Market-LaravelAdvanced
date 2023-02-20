<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\stores;
use App\Models\drivers;
use App\Models\users;
use App\Models\notify;
use App\Models\notifications;
use Illuminate\Support\Str;

//stop code
class sendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public  $record, $typeUsers,  $timeout = 9999999;

    public function __construct($record, $typeUsers)
    {
        $this->record= $record;
        $this->typeUsers= $typeUsers;

    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //تسجيل الاشعارات للمستخدمين المحددين
        if($this->typeUsers == 'all')
        {
            $models=['App\Models\users','App\Models\drivers','App\Models\stores'];
        }
        else if($this->typeUsers == 'drivers')
        {
            $models=['App\Models\drivers'];
        }
        else if($this->typeUsers == 'users')
        {
            $models=['App\Models\users'];
        }
        else if($this->typeUsers == 'stores')
        {
            $models=['App\Models\stores'];
        }


        $models = $this->typeUsers?$models:[$this->typeUsers];
        foreach($models as $model){
            $modelClass= $model;
            $modelClass::where('isActive',1)->chunk(100,function($record) use($model){
                foreach($record as $recorded){
                    $notify = notify::create([
                        "notifications_id"=>$this->record->id,
                        "isSeen"=>0,
                        $model."_id"=>$recorded->id,
                        'createdAt' => now(),
                    ]);
                }
            });
        }

    }
}
