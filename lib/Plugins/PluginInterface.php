<?php

namespace Forge\Plugins;

use Forge\Plugins\PluginServiceProviderInterface as ServiceProvider;

interface PluginInterface
{
    public function boot(ServiceProvider $provider): void;
    public function register(ServiceProvider $provider): void;
}
