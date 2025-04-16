<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('markdown', function ($expression) {
            return "<?php echo \Illuminate\Support\Str::of($expression)->markdown(); ?>";
        });

        Blade::directive('shortDate', function ($date) {
            return "<?php echo \Carbon\Carbon::parse($date)->day . ' ' . \Carbon\Carbon::parse($date)->locale(config('app.locale'))->shortMonthName; ?>";
        });

        Blade::directive('longDate', function ($date) {
            return "<?php echo \Carbon\Carbon::parse($date)->day . ' ' . \Carbon\Carbon::parse($date)->locale(config('app.locale'))->translatedFormat('F') . ' ' . \Carbon\Carbon::parse($date)->year; ?>";
        });
    }
}
