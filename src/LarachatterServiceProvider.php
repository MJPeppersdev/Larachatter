<?php

namespace Launcher\Larachatter;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Launcher\Larachatter\Commands\InstallCommand;
use Launcher\Larachatter\Setup\MigrationsHandler;

class LarachatterServiceProvider extends ServiceProvider
{
    use EventMap;

    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../publishable/views', 'larachatter');
        $this->loadTranslationsFrom(__DIR__.'/../publishable/lang', 'larachatter');
        $this->registerEvents();

        require __DIR__.'/../routes/channels.php';
    }
    
    public function register()
    {
        $this->registerPublishable();
        $this->mergeConfigFrom(__DIR__.'/../publishable/config/larachatter.php', 'larachatter');

        $this->loadHelpers();

        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }

        $this->app->singleton('larachatter', function () {
            return new Larachatter();
        });
    }

    protected function registerPublishable()
    {
        $_path = __DIR__.'/../publishable/';

        $publishable = [
            'larachatter-config' => ["{$_path}config/larachatter.php" => config_path('larachatter.php')],
            'larachatter-public' => ["{$_path}public" => public_path('vendor/larachatter')],
            'larachatter-sass'   => [__DIR__.'/../resources/sass/' => resource_path('sass/vendor/larachatter')],
            'larachatter-js'     => [__DIR__.'/../resources/js/' => resource_path('js/vendor/larachatter')],
            'larachatter-seeds'  => ["{$_path}database/seeds/" => database_path('seeds')],
            'larachatter-lang'   => ["{$_path}lang/" => resource_path('lang')],
            'larachatter-views'  => ["{$_path}views/" => resource_path('views/vendor/larachatter')],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }

        $this->registerPublishableMigrations();
    }

    private function registerPublishableMigrations()
    {
        $_migrations = [
            'add_larachatter_user_fields',
            'create_larachatter_messages_table',
            'add_slug_larachatter_user_table',
        ];

        $_publishable = (new MigrationsHandler())->processMigrations($_migrations);

        if (count($_publishable) > 0) {
            $this->publishes($_publishable, 'larachatter-migrations');
        }
    }

    private function registerConsoleCommands()
    {
        $this->commands(InstallCommand::class);
    }

    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }
}
