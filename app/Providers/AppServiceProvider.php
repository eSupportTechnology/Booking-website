<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('translator', function ($app) {
            $loader = new FileLoader(new Filesystem, base_path('lang')); // <-- custom lang path here
            $translator = new Translator($loader, $app['config']['app.locale']);
            $translator->setFallback($app['config']['app.fallback_locale']);

            return $translator;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::setLocale(session('locale', config('app.locale')));
    }
}
