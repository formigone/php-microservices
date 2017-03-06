<?php

namespace App\Services;

use App\Providers\ArticleProvider;
use Monolog\Logger;

class ArticleService
{
    /** @var ArticleProvider */
    private $provider;

    /** @var  Logger */
    private $log;

    public function __construct(ArticleProvider $provider, Logger $log)
    {
        $this->provider = $provider;
        $this->log = $log;
    }

    /**
     * @param $storyId
     * @return mixed
     * @throws \Exception
     */
    public function getStoryById($storyId)
    {
        $story = $this->provider->getStoryById($storyId);
        if (empty($story)) {
            throw new \Exception('Story not found');
        }

        $this->log->info('Getting story by ID', ['storyId' => $storyId, 'story' => $story]);
        return $story;
    }

    /**
     * @return array
     */
    public function getMainStory()
    {
        return $this->provider->getMainStory();
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getStories($limit = 10)
    {
        return $this->provider->getStories($limit);
    }

    /**
     * @param int $total
     * @return array
     */
    public function genRandomComments($total = -1)
    {
        if ($total < 1) {
            $total = mt_rand(3, 6);
        }

        $this->log->info('Generating random comments', ['total' => $total]);
        return $this->provider->genRandomComments($total);
    }
}
