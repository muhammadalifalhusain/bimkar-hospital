<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\RupiahHelper;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo \\App\\Helpers\\RupiahHelper::rupiah($expression); ?>";
        });
    }
}
