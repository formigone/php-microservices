<?php

namespace App\Controllers;

use App\Services\ArticleService;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

/**
 * Class IndexController
 * @package KSLWeb\Controllers
 */
class IndexController implements ControllerProviderInterface
{
    const MAIN_TEMPLATE = 'homepage.html.twig';

    /** @var ArticleService */
    private $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        $controller->get('/', function (Application $app) {
            return $app['templating']->render(self::MAIN_TEMPLATE, $this->indexAction());
        });

        return $controller;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        return [
            'mainStory' => $this->service->getMainStory(),
            'headlines' => $this->service->getStories(100),
            'trending' => $this->service->getStories(5),
        ];
    }
}
