<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\Broadway\UuidGenerator\UuidGeneratorInterface::class, function () {
            return new Version4Generator();
        });
    }
}
