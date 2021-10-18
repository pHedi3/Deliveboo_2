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
                    'merchantId' => '97nq5pr6s49tqw7j',
                    'publicKey' => '2k9yhdg6d559xs3q',
                    'privateKey' => '432073983139685455375c376cc2833f'
                ]
            );
        });
    }
}