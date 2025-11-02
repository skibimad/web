<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SkibidiMadnessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../config/skibidi-madness.php', 'skibidi-madness'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'skibidi-madness');

        // Publishing assets when used as a package
        if ($this->app->runningInConsole()) {
            // Publish configuration
            $this->publishes([
                __DIR__.'/../../config/skibidi-madness.php' => config_path('skibidi-madness.php'),
            ], 'skibidi-config');

            // Publish migrations
            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'skibidi-migrations');

            // Publish views
            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/vendor/skibidi-madness'),
            ], 'skibidi-views');

            // Publish public assets
            $this->publishes([
                __DIR__.'/../../public/res' => public_path('res'),
                __DIR__.'/../../public/scripts' => public_path('scripts'),
                __DIR__.'/../../public/styles' => public_path('styles'),
            ], 'skibidi-assets');
        }
    }
}
