<?php

namespace Irando\CountryCodes;

use Illuminate\Support\ServiceProvider;

class CountryCodesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Irando\CountryCodes\CountryCodesontroller');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'country-codes');

        $this->publishes([
            __DIR__.'/app/Models' => base_path('app/Models'),
            __DIR__ . '/database/seeders/CountryCodesTableSeeder.php' => database_path('seeders/CountryCodesTableSeeder.php'),
            __DIR__.'/resources/views' => resource_path('views/vendor/irando/country-codes'),
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'country-codes');
    }
}
