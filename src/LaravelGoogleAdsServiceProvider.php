<?php

namespace AndreOrtu\LaravelGoogleAds;

use Illuminate\Support\ServiceProvider;

class LaravelGoogleAdsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/googleads.php' => config_path('googleads.php'),
        ]);
    }
}
