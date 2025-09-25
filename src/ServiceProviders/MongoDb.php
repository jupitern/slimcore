<?php

namespace SlimCore\ServiceProviders;
use MongoDB\Client;
use SequelMongo\QueryBuilder;
use SlimCore\App;

class MongoDb implements ProviderInterface
{

    public static function register(App $app, $serviceName, array $settings = []): void
    {
        $conn = new Client($settings["uri"], $settings["options"]);
        $db = $conn->selectDatabase($settings['db']);

        if ((bool)$settings["setGlobal"] && class_exists('SequelMongo\QueryBuilder')) {
            // Set a global connection to be used on all new QueryBuilders
            QueryBuilder::setGlobalConnection($db);
        }

        $app->registerInContainer($serviceName, $db);
    }

}