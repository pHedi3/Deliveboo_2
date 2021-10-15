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
        $gateway = new Gateway([  
            'environment' => 'sandbox',
            'merchantId' => 'm97fk7ttg9xnbybr',
            'publicKey' => '2mts6m625swjdcs3',
            'privateKey' => '058142576c04be715e36d2aaa65b1f57'
        ],);
    }
}