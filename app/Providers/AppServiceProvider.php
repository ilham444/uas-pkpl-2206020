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
        Blade::directive('estimasi', function ($minutes) {
            return "<?php
        \$hours = floor($minutes / 60);
        \$mins = $minutes % 60;
        \$text = '';
        if (\$hours > 0) {
            \$text .= \$hours . ' jam';
        }
        if (\$mins > 0) {
            \$text .= (\$hours > 0 ? ' ' : '') . \$mins . ' menit';
        }
        if (\$text === '') {
            \$text = 'Kurang dari 1 menit';
        }
        echo \$text;
    ?>";
        });
    }
}
