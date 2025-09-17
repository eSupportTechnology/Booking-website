<?php

namespace App\Providers;

use App\Actions\SMS\SendSmsViaGetAction;
use App\Actions\SMS\SendSmsViaPostAction;
use App\Actions\SMS\ValidatePhoneNumberAction;
use App\Services\QuickSendSmsService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Gate;
use App\Models\Property;
use App\Policies\PropertyPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ValidatePhoneNumberAction::class);

        $this->app->singleton(SendSmsViaPostAction::class, function ($app) {
            return new SendSmsViaPostAction(
                $app->make(ValidatePhoneNumberAction::class)
            );
        });

        $this->app->singleton(SendSmsViaGetAction::class, function ($app) {
            return new SendSmsViaGetAction(
                $app->make(ValidatePhoneNumberAction::class)
            );
        });

        $this->app->singleton(QuickSendSmsService::class, function ($app) {
            return new QuickSendSmsService(
                $app->make(SendSmsViaPostAction::class),
                $app->make(SendSmsViaGetAction::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Property::class, PropertyPolicy::class);
    }
}
