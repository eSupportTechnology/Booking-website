<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class HttpClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Http::macro('exchangeApi', function () {
            return Http::withOptions([
                'verify' => env('CURL_CA_BUNDLE', true),
                'timeout' => 10,
            ]);
        });
    }
}
