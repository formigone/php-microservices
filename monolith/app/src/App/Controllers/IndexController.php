<?php

namespace App\Controllers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

/**
 * Class IndexController
 * @package KSLWeb\Controllers
 */
class IndexController implements ControllerProviderInterface
{
    const MAIN_TEMPLATE = 'layout.html.twig';

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        $controller->get('/', function (Application $app) {
            $data = [
                'rnd' => [],
            ];
            for ($i = 0; $i < 10; $i++) {
                $data['rnd'][] = mt_rand(0, 100);
            }
            return $app['templating']->render(self::MAIN_TEMPLATE, $data);
        });
        return $controller;
    }
}
