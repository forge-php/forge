## Forge
Forge is a command line utility that you can extend as your liking. It's primary focus is code generation,
but it can do anything a command line tool can via plugins. It's very easy to write your own plugins to use with forge.

With Forge, you can use a single tool for code generation, project management, container management and so much more instead of needing to remember on 
a combination of a thousand cli tools. If something does not exist, you can write your own plugin in like 5 minutes and create your own commands.


## Use Cases 
Forge is a general purpose cli tool. Meaning, you can extend forge to make it do whatever you want to. 
For me, the use case is mostly code genration. I tend to write similar code too often and because of that, repeated tasks become boring.
Forge can be used to literally forge components, controllers, or any other kind of boilerplate code that you hate writing.
But since the plugin ecosystem makes it so much more versatile, it can be used for practically anything that is possible on a command like application.


## Plugins 
Install plugins by registering the plugin class in `config/plugins.php`.

```php 
    // config/plugins.php
    return [
        MyPlugin::class => ['dev' => true, 'prod' => true],
        SomeOtherPlugin::class => ['all' => true]
    ];
```

### Creating a Plugin 
All Forge plugins must implement `Forge\Plugins\PluginInterface` interface.
For ease of use, we have provided `Forge\Plugins\Plugin` class which wraps all the boilerplate so you can focus on actually building your application.

```php 

use Forge\Plugins\Plugin;
use Forge\Plugins\PluginServiceProviderInterface;

class MyPlugin extends Plugin 
{
    public function name(): string 
    {
        return 'MyPlugin';
    }

    public function boot(PluginServiceProviderInterface $provider): void 
    {
        $provider->loadStubsFrom(__DIR__ . '/stubs/', $this->name());
        $provider->commands([
            SomeConsoleCommand::class
        ]);
    }
}
```

Now, just regsiter the class name in `config/plugins.php` and we should be good to go.


