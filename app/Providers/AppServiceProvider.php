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
use Illuminate\Support\Facades\Schema;
use App\Models\Property;
use App\Policies\PropertyPolicy;
use App\Models\Booking;
use App\Observers\BookingObserver;

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

        // Register currency services
        $this->app->singleton(\App\Services\CurrencyService::class);
        $this->app->singleton(\App\Services\CurrencyManager::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Gate::policy(Property::class, PropertyPolicy::class);
        Booking::observe(BookingObserver::class);
        
        // Register Blade directive for currency formatting
        \Blade::directive('currency', function ($expression) {
            return "<?php echo \App\Helpers\CurrencyHelper::convertAndFormat($expression); ?>";
        });
        
        // Register partner-specific currency directive that forces USD
        \Blade::directive('partnerPrice', function ($expression) {
            $parts = explode(',', str_replace(['(', ')', ' '], '', $expression));
            $amount = $parts[0] ?? '0';
            return "<?php echo \App\Helpers\CurrencyHelper::convertAndFormat($amount, 'USD'); ?>";
        });
        
        \Blade::directive('price', function ($expression) {
            $parts = explode(',', str_replace(['(', ')', ' '], '', $expression));
            $amount = $parts[0] ?? '0';
            $currency = $parts[1] ?? "'USD'";
            return "<?php echo \App\Helpers\CurrencyHelper::convertAndFormat($amount, $currency); ?>";
        });
    }

    /**
     * Bootstrap any application services.
     */

}
