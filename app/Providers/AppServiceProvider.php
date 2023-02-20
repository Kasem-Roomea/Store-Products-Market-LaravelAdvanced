<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\categories;
use App\Observers\categoriesObserver;

use App\Models\admins;
use App\Observers\adminsObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        categories::observe(categoriesObserver::class);
        admins::observe(adminsObserver::class);
    }
}
