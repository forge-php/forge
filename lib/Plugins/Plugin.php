<?php

namespace Forge\Plugins;

use Forge\Plugins\PluginServiceProviderInterface as ServiceProvider;


abstract class Plugin implements PluginInterface
{
    public function register(ServiceProvider $provider): void
    {

    }

    public function boot(ServiceProvider $provider): void
    {

    }
}
