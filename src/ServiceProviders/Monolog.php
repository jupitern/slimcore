<?php

namespace SlimCore\ServiceProviders;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use SlimCore\App;
use SlimCore\Monolog\Handler\SisHandler;
use SlimCore\Monolog\Handler\LogdnaHandler;
use SlimCore\Monolog\Handler\TelegramHandler;
use Monolog\Handler\SyslogUdpHandler;

class Monolog implements ProviderInterface
{

    public static function register(App $app, $serviceName, array $settings = []): void
    {
        $monolog = new Logger($serviceName);

        foreach ($settings as $logger) {

            if ($logger['type'] == 'file' && (bool)$logger['enabled']) {
                $formatter = new LineFormatter(null, null, true);
                $formatter->includeStacktraces(true);

                $handler = new StreamHandler($logger['path'], $logger['level']);
                $handler->setFormatter($formatter);
                $monolog->pushHandler($handler);

            } elseif ($logger['type'] == 'sis' && (bool)$logger['enabled']) {
                $handler = new SisHandler($logger['appKey'], $logger['host'] ?? null);
                $monolog->pushHandler($handler);

            } elseif ($logger['type'] == 'telegram' && (bool)$logger['enabled']) {
                $handler = new TelegramHandler($logger['apiKey'], $logger['chatId'], $logger['level']);
                $monolog->pushHandler($handler);

            } elseif ($logger['type'] == 'logdna' && (bool)$logger['enabled']) {
                $handler = new LogdnaHandler($logger['ingestionKey'], $logger['level']);
                $monolog->pushHandler($handler);

            } elseif ($logger['type'] == 'papertrail' && (bool)$logger['enabled']) {
                $output = "%channel%.%level_name%: %message%";
                $formatter = new LineFormatter($output);

                $handler = new SyslogUdpHandler($logger['host'], $logger['port']);
                $handler->setFormatter($formatter);
                $monolog->pushHandler($handler);

            }
        }

        $app->registerInContainer($serviceName, $monolog);
    }

}
