<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mic\Users\Controllers\IndexController;
use Mic\Users\Services\UserService;
use Mic\Users\Providers\UserProvider;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Gelf\Transport\TcpTransport;
use Gelf\Publisher;


define('PRJ_ROOT', __DIR__ . '/..');
define('APP_DEV', getenv('APP_DEV') ?: 'production');

$app = new Silex\Application();

$config = json_decode(file_get_contents(__DIR__ . '/../config/app.json'), true);

$app['debug'] = APP_DEV === 'development';

$app['logger'] = function () use ($config) {
    $log = new Logger('user-service');
    $log->pushHandler(new ErrorLogHandler());
    $log->pushProcessor(new MemoryPeakUsageProcessor());
    ErrorHandler::register($log);

    try {
        $transport = new TcpTransport(
            $config['log']['graylog']['host'],
            $config['log']['graylog']['port']
        );
        $handler = new GelfHandler(new Publisher($transport));
        $log->pushHandler($handler);
    } catch (\Exception $e) {
        $log->error('Error adding GELF handler', [
            'message' => $e->getMessage(),
            'stack' => $e->getTraceAsString(),
        ]);
    }

    if (php_sapi_name() !== 'cli') {
        $log->pushProcessor(new WebProcessor());
    }

    return $log;
};

$app['userService'] = function () use ($config) {
    $provider = new UserProvider($config['db']['path']);
    return new UserService($provider);
};

$app['indexController'] = function () use ($app) {
    return new IndexController($app['userService']);
};

include __DIR__ . '/../app/routes.php';

$app->run();
