<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\CommandHandling\SimpleCommandBus;
use Illuminate\Support\ServiceProvider;
use Nwidart\LaravelBroadway\Registries\CommandRegistry;

class CommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Broadway\CommandHandling\CommandBusInterface', function () {
            return new SimpleCommandBus();
        });

        $this->app->singleton('laravelbroadway.command.registry', function ($app) {
            return new CommandRegistry($app['Broadway\CommandHandling\CommandBusInterface']);
        });
    }
}
