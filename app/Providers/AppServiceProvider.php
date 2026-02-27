<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Blade directives
        Blade::directive('money', function ($amount) {
            return "Rp <?php echo number_format($amount, 0, ',', '.'); ?>";
        });
    }
}
