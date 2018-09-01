<?php

namespace FileSearch;

use FileSearch\Console\ScanFiles;
use FileSearch\Console\SearchCommand;
use Illuminate\Support\ServiceProvider;


class FileSearchServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'filesearch');
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/filesearch'),
        ]);
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SearchCommand::class,
                ScanFiles::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
    }
}
