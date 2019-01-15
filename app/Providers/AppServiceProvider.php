<?php

namespace Postici\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
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
        /*
         * For the application to use the protocol.
         */
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        URL::forceScheme($protocol);

        $pattern = '/^(([\p{L}]+)|([\p{L}]+[\p{L}\s\-]*[\p{L}]+))$/u';

        Validator::extend('alpha_space_dash',
            function ($value) use ($pattern) {
                return preg_match($pattern, $value);
            }
        );
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
