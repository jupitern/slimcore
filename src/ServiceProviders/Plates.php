<?php

namespace SlimCore\ServiceProviders;
use League\Plates\Engine;
use SlimCore\App;

class Plates implements ProviderInterface
{
    public static function register(App $app, $serviceName, array $settings = []): void
    {
        $engine = new Engine();
        foreach ($settings['templates'] as $name => $path) {
            $engine->addFolder($name, $path, true);
        }

        if (array_key_exists('extensions', $settings)) {
            foreach ($settings['extensions'] as $extension) {
                $engine->loadExtension(new $extension);
            }
        }

        $app->registerInContainer($serviceName, $engine);
    }
}
