<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Models\ConfiguracionSistema;


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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Compartir la configuración de sistema con todas las vistas
        $configuracionSistema = rescue(fn () => ConfiguracionSistema::first(), null, false);
        View::share('configuracionSistema', $configuracionSistema);
    }

}
