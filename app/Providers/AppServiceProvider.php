<?php

namespace App\Providers;

use App\Custom\Authorization;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('canAccess', function ($permissionName) {
            //Authorization::class
            return "<?php if (App\Custom\Authorization::canAccess($permissionName)): ?>";
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
