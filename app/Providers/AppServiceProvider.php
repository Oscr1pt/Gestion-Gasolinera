<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
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
        // Rutas relativas para CSS/JS compilados (evita fallos si APP_URL no coincide con Herd)
        Vite::createAssetPathsUsing(fn (string $path, ?bool $secure = null) => '/'.ltrim($path, '/'));

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $turnos_config = \App\Models\ConfiguracionTurno::all()->keyBy('turno');
                $generales_config = \App\Models\ConfiguracionGeneral::all()->keyBy('clave');
                
                $view->with('turnos_config', $turnos_config);
                $view->with('generales_config', $generales_config);
            } catch (\Exception $e) {
                // Ignore if tables don't exist yet (e.g. during migrations)
            }
        });
    }
}
