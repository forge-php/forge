<?php

namespace Forge\Plugins;

use Illuminate\Support\Collection;

class PluginManager
{
    protected Collection $items;

    public function __construct() {
        $this->items = new Collection([]);

        foreach(config('plugins') as $class => $config) {
            if (!class_exists($class) || !class_implements($class, PluginInterface::class)) {
                throw new \Exception(
                    sprintf(
                        'Invalid plugin class %s registered in %s. Please make sure that the plugin class implements %s',
                        $class,
                        'config/plugins.php',
                        PluginInterface::class
                    )
                );
            }
            $active = $config['all'] ?? $config[env('APP_ENV')] ?? false;
            $this->items->add([
                'name' => $class::name(),
                'class' => $class,
                'active' => $active
            ]);
        }
    }

    public function active(): Collection
    {
        return $this->plugins()->filter(fn($plugin) => $plugin['active'] === true);
    }

    public function plugins(): Collection
    {
        return $this->items;
    }

    public function isActive(string|PluginInterface $plugin): bool
    {
        if ($plugin instanceof PluginInterface) {
            $plugin = $plugin::class;
        }
        $exists = $this->plugins()
                ->filter(fn($pl) => $pl['name'] === $plugin && $pl['active'] === true)
                ->first();

        return (bool) $exists;
    }
}
