<?php

namespace Forge\Plugins;

interface PluginServiceProviderInterface
{
    public function loadStubsFrom(string $path, string $name): void;

    /**
     * @param array<int,string> $commands
     * @return void
     */
    public function commands($commands);

}
