<?php

namespace App\Controllers;

use App\Services\ArticleService;
use App\Services\UserService;
use Gelf\Logger;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

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
        /** @var Logger $log */
        $log = $app['logger'];
        $log->info('User request');

        $controller->get('/', function (Application $app) {
            return $app['templating']->render(self::MAIN_TEMPLATE, $this->indexAction());
        });

        $controller->post('/login', function (Request $req) use ($app) {
            $username = $req->get('username', '');
            $password = $req->get('password', '');

            $this->userService->login($username, $password);
            return $app->redirect('/');
        });

        $controller->get('/logout', function (Request $req) use ($app) {
            $this->userService->logout();
            return $app->redirect('/');
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
