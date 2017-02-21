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
                'headlines' => [
                    [
                        'img' => '/img/holidays.jpg',
                        'title' => 'Thousands get ready for holidays',
                        'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                        'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
                    ],
                    [
                        'img' => '/img/heavy-traffic.jpg',
                        'title' => 'Heavy traffic as people drive home',
                        'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                        'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
                    ],
                ],
            ];
            return $app['templating']->render(self::MAIN_TEMPLATE, $data);
        });
        return $controller;
    }
}
