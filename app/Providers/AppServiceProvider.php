<?php

namespace App\Providers;

// SUPPRIMEZ la ligne "use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;" en haut
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // On utilise la chaîne de caractères complète pour éviter l'erreur de classe inexistante
        if ($this->app->isLocal() && class_exists('\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
            $this->app->register('\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
