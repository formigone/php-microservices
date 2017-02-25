<?php

namespace App\Providers;

use Comp\Service\Article\Client;

class ArticleProvider
{
    /** @var Client $client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $articleId
     * @param array $fields
     * @return array
     * @throws
     */
    public function getArticleById($articleId, array $fields = [])
    {
        return $this->cliet->getArticleById($articleId, $fields);
    }
}
