<?php

namespace App\Controllers;

use App\Services\ArticleService;
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
        $controller->get('/{story}/{title}', function (array $story) use ($app) {
            $recommendations = $this->service->getStories(4);
            $recommendations = array_filter($recommendations, function ($row) use ($story) {
                return $row['id'] !== $story['id'];
            });
            $recommendations = array_slice($recommendations, 0, 3);
            $comments = $this->service->genRandomComments();

            $data = [
                'story' => $story,
                'comments' => $comments,
                'recommendations' => $recommendations,
            ];
            return $app['templating']->render(self::MAIN_TEMPLATE, $data);
        })->convert('story', function ($storyId) {
            $story = $this->service->getStoryById($storyId);
            return $story;
        });

        return $controller;
    }
}
