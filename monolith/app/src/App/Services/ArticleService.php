<?php

namespace App\Services;

use App\Providers\ArticleProvider;

class ArticleService
{
    /** @var ArticleProvider */
    private $provider;

    public function __construct(ArticleProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param $storyId
     * @return mixed
     */
    public function getStoryById($storyId)
    {
        return $this->provider->getStoryById($storyId);
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

        return $this->provider->genRandomComments($total);
    }
}
