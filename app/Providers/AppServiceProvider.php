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
    // On ne charge l'IDE Helper que si on est en local et que la classe existe
    if ($this->app->environment('local', 'dev')) {
        if (class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
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
