<?php

namespace Laravel\Settings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) return;

        $this->publishes([
            __DIR__ . '/../config/settings.php' => config_path('settings.php'),
        ], 'settings');

        if (!class_exists('CreateSettingsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/2022_12_02_165000_create_settings_table.php' => database_path('migrations/' . date('Y_m_d_His') . '_create_settings_table.php'),
            ], 'migrations');
        }

        $this->commands([
            Commands\CacheSettings::class,
            Commands\ClearCachedSettings::class,
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', 'settings');
        $this->app->singleton(Settings::class);
        $this->app->alias(Settings::class, 'settings');
    }
}
