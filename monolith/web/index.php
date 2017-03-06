<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \App\Controllers\IndexController;
use \App\Controllers\ArticleController;
use \App\Services\ArticleService;
use \App\Providers\ArticleProvider;
use \App\Services\UserService;
use \App\Providers\UserProvider;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\GelfHandler;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Gelf\Transport\TcpTransport;
use Gelf\Publisher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

define('PRJ_ROOT', __DIR__ . '/..');
define('APP_DEV', getenv('APP_DEV') ?: 'production');
session_start();

$app = new Silex\Application();

$config = json_decode(file_get_contents(__DIR__ . '/../config/app.json'), true);

$app['debug'] = APP_DEV === 'development';

$app['logger'] = function () use ($config) {
    $log = new Logger('monolith');
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

$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => PRJ_ROOT . $config['twig']['path']]);
$app['templating.engines'] = function () {
    return [
        'twig',
        'php',
    ];
};
$app['templating.loader'] = function () {
    return new Symfony\Component\Templating\Loader\FilesystemLoader([__DIR__ . '/views/%name%']);
};
$app['templating.template_name_parser'] = function () {
    return new Symfony\Component\Templating\TemplateNameParser();
};
$app['templating.engine.php'] = function ($app) {
    $engine = new Symfony\Component\Templating\PhpEngine(
        $app['templating.template_name_parser'],
        $app['templating.loader']
    );
    $engine->set(new Symfony\Component\Templating\Helper\SlotsHelper());
    return $engine;
};
$app['templating.engine.twig'] = function ($app) {
    return new Symfony\Bridge\Twig\TwigEngine($app['twig'], $app['templating.template_name_parser']);
};
$app['templating'] = function ($app) {
    $engines = [];
    foreach ($app['templating.engines'] as $i => $engine) {
        if (is_string($engine)) {
            $engines[$i] = $app[sprintf('templating.engine.%s', $engine)];
        }
    }
    return new Symfony\Component\Templating\DelegatingEngine($engines);
};

$app['articleService'] = function () use ($app) {
    $provider = new ArticleProvider($app['logger']);
    return new ArticleService($provider, $app['logger']);
};

$app['userService'] = function () {
    $client = new \GuzzleHttp\Client();
    $provider = new UserProvider($client);
    return new UserService($provider);
};

$app['indexController'] = function () use ($app) {
    return new IndexController($app['articleService'], $app['userService']);
};

$app['articleController'] = function () use ($app) {
    return new ArticleController($app['articleService'], $app['userService']);
};

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    /** @var Logger $log */
    $log = $app['logger'];

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    $log->error('Error', [
        'code' => $code,
        'message' => $e->getMessage(),
        'stack' => $e->getTraceAsString(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'response' => $message,
    ]);

    return new Response($message);
});

include __DIR__ . '/../app/routes.php';

$app->run();
