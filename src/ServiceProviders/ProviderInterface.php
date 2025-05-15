<?php

namespace SlimCore\ServiceProviders;
use SlimCore\App;

interface ProviderInterface
{
    public static function register(App $app, string $serviceName, array $settings = []): void;
}