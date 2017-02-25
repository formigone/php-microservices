<?php

namespace App\Controllers;

use App\Services\ArticleService;
use App\Services\UserService;
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
    private $articleService;

    /** @var UserService */
    private $userService;

    public function __construct(ArticleService $articleService, UserService $userService)
    {
        $this->articleService = $articleService;
        $this->userService = $userService;
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
            'mainStory' => $this->articleService->getMainStory(),
            'headlines' => $this->articleService->getStories(100),
            'trending' => $this->articleService->getStories(5),
            'user' => $this->userService->getCurrentUser(),
        ];
    }
}
