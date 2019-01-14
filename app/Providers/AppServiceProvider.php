<?php

namespace Postici\Providers;

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