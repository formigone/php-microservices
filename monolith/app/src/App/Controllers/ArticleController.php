<?php

namespace App\Controllers;

use App\Services\ArticleService;
use App\Services\UserService;
use Gelf\Logger;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

/**
 * Class ArticleController
 * @package App\Controllers
 */
class ArticleController implements ControllerProviderInterface
{
    const MAIN_TEMPLATE = 'article.html.twig';

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

        $controller->get('/{story}/{title}', function (array $story) use ($app) {
            return $app['templating']->render(self::MAIN_TEMPLATE, $this->storyAction($story));
        })->convert('story', function ($storyId) {
            $story = $this->articleService->getStoryById($storyId);
            return $story;
        });

        return $controller;
    }

    public function storyAction(array $story)
    {
        $recommendations = $this->articleService->getStories(4);
        $recommendations = array_filter($recommendations, function ($row) use ($story) {
            return $row['id'] !== $story['id'];
        });
        $recommendations = array_slice($recommendations, 0, 3);
        $comments = $this->articleService->genRandomComments();

        return [
            'story' => $story,
            'comments' => $comments,
            'recommendations' => $recommendations,
            'user' => $this->userService->getCurrentUser(),
        ];
    }
}
