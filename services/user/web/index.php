<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \App\Controllers\IndexController;
use \App\Services\UserService;
use \App\Providers\UserProvider;

define('PRJ_ROOT', __DIR__ . '/..');

$app = new Silex\Application();

$config = json_decode(file_get_contents(__DIR__ . '/../config/app.json'), true);

$app['debug'] = getenv('APP_DEV') === 'development';

$app['userService'] = function () use ($config) {
    $provider = new UserProvider($config['db']['path']);
    return new UserService($provider);
};

$app['indexController'] = function () use ($app) {
    return new IndexController($app['userService']);
};

include __DIR__ . '/../app/routes.php';

$app->run();
