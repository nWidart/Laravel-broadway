<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\Serializer\SimpleInterfaceSerializer;
use Illuminate\Support\ServiceProvider;

class SerializersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Broadway\Serializer\SerializerInterface', function () {
            return new SimpleInterfaceSerializer();
        });
    }
}
