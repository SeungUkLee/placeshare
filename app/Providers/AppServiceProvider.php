<?php

namespace App\Providers;

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
        view()->composer('*', function ($view) {

            $currentUser = auth()->user();
            $currentRouteName = \Route::currentRouteName();
            $currentLocale = app()->getLocale();
            $currentUrl = current_url();

            $view->with(compact('currentUser', 'currentRouteName', 'currentLocale', 'currentUrl'));
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
