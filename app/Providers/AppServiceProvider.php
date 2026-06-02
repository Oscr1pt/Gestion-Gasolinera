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
    }
}
