<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
   /**  public function register()
    * {
    *    if ($this->app->environment() !== 'production') {
    *       $this->app->register(IdeHelperServiceProvider::class);
    *  }
    *}
    */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            // Only register the IDE helper if the package class exists to avoid compile errors
            if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
                $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
            }
        }
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
		Schema::defaultStringLength(191);
    }
}
