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
        if (env('APP_DEBUG')) {
            \DB::listen(function ($query) {
                \Log::info($query->sql . ' ' . json_encode($query->bindings) . '  ' . $query->time . 'ms');
            });
        }
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
