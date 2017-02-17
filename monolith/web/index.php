<?php

require_once __DIR__ . '/../vendor/autoload.php';

define('PRJ_ROOT', __DIR__ . '/..');

$app = new Silex\Application();

$config = json_decode(file_get_contents(__DIR__ . '/../config/app.json'), true);

$app['debug'] = getenv('APP_DEV') === 'development';
$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => PRJ_ROOT . $config['twig']['path']]);
$app['templating.engines'] = function () {
    return [
        'twig',
        'php',
    ];
};

$app['templating.loader'] = function () {
    return new Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__ . '/views/%name%');
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

include __DIR__ . '/../app/routes.php';

$app->run();
