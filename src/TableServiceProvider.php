<?php

namespace Paksuco\Table;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Paksuco\Table\Components\Table;

class TableServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();
        // $this->handleMigrations();
        $this->handleViews();
        // $this->handleTranslations();
        // $this->handleRoutes();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind any implementations.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function handleConfigs()
    {
        $configPath = __DIR__ . '/../config/paksuco-table.php';

        $this->publishes([$configPath => base_path('config/paksuco-table.php')]);

        $this->mergeConfigFrom($configPath, 'paksuco-table');
    }

    private function handleTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'paksuco-table');
    }

    private function handleViews()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'paksuco-table');

        $this->publishes([__DIR__.'/../views' => base_path('resources/views/vendor/paksuco-table')]);

        Livewire::component("paksuco-table::table", Table::class);
    }

    private function handleMigrations()
    {
        $this->publishes([__DIR__ . '/../migrations' => base_path('database/migrations')]);
    }

    private function handleRoutes()
    {
        include __DIR__.'/../routes/routes.php';
    }
}

if (!function_exists("base_path")) {
    function base_path($path)
    {
        return \Illuminate\Support\Facades\App::basePath($path);
    }
}
