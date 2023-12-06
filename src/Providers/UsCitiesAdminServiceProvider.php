<?php

namespace Toaha\UsCitiesAdmin\Providers;

use Illuminate\Support\ServiceProvider;

class UsCitiesAdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->publishes([
            __DIR__  . '/../../publishable/assets' => public_path('vendor/Toaha/UsCitiesAdmin/assets'),
        ], 'storesetup');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'uscitiesadmin');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/sidebar.php', 'navigation'
        );
    }
}
