<?php

namespace Forge\Plugins;

use Forge\Plugins\PluginInterface;
use Forge\Plugins\PluginManager;
use Forge\Plugins\PluginServiceProviderInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class PluginsServiceProvider extends ServiceProvider implements PluginServiceProviderInterface
{
    protected PluginManager $pluginManager;

    public function __construct(Application $app) {
        parent::__construct($app);

        $this->pluginManager = app()->make(PluginManager::class);
    }


    public function boot(): void
    {
        $this->pluginManager
            ->active()
            ->map(function($config) {

                /** @var PluginInterface $plugin **/
                $plugin = app()->get($config['class']);
                $plugin->boot($this);
            });

    }

    public function register(): void
    {
        $this->pluginManager
            ->active()
            ->map(function($config) {
                /** @var PluginInterface $plugin **/
                $plugin = app()->get($config['class']);
                $plugin->register($this);
            });
    }

    public function loadStubsFrom(string $path, string $namespace): void
    {
        $this->loadViewsFrom($path, $namespace);
    }
}
