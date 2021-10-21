<?php

namespace App\Providers;
use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway(
                [
                    'environment' => 'sandbox',
                    'merchantId' => 'ptbgwhxxzdk7bh3c',
                    'publicKey' => 'ybh53b44ppm33c2v',
                    'privateKey' => '466a6d91b4b62dbc338cd5ebf203d874'
                ]
            );
        });
    }
}