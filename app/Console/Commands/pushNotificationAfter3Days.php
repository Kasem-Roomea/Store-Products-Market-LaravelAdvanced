<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\orders;
use App\Models\reviews;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;

class pushNotificationAfter3Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushNotifyAfter3Days:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command used to push notification to user after 3 days from created at
    ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $records = orders::where("status","finished")->where("pushAfter3Day",0)->get();
        foreach ($records as $record){
            if(reviews::where("orders_id",$record->id)->count()==0){
                helper::newNotify(
                    [$record->user],
                    "Trolley Omman wants to know your rating of the products you have purchased",
                    "يريد عمان تقييمك للمنتجات االتي اشتريتها"
                );
                $record->pushAfter3Day =1;
                $record->save();

            }
                        
        }
        $this->info("sent ssuccefully");
        
    }
}
