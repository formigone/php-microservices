<?php

namespace App\Services;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ArticleService
{
    private $data;

    public function __construct()
    {
        $this->data = $data = [
            [
                'id' => substr(md5(0), 0, 6),
                'img' => '/img/cat-001.jpg',
                'title' => 'Weird cat video goes viral online',
                'slug' => 'weird-cat-video-goes-viral-online',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(1), 0, 6),
                'img' => '/img/holidays.jpg',
                'title' => 'Thousands get ready for holidays',
                'slug' => 'thousands-get-ready-for-holidays',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(2), 0, 6),
                'img' => '/img/heavy-traffic.jpg',
                'title' => 'Heavy traffic as people drive home',
                'slug' => 'heavy-traffic-as-people-drive-home',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(3), 0, 6),
                'img' => '/img/ski.jpg',
                'title' => 'Meanwhile in Utah',
                'slug' => 'meanwhile-in-utah',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(4), 0, 6),
                'img' => '/img/beach.jpg',
                'title' => 'Meanwhile in Fortaleza',
                'slug' => 'meanwhile-in-fortaleza',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(5), 0, 6),
                'img' => '/img/cards.jpg',
                'title' => '4 Cards that start with the letter "A"',
                'slug' => '4-cards-that-start-with-the-letter-a',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(6), 0, 6),
                'img' => '/img/train.jpg',
                'title' => 'Top 10 ways to nap in the train',
                'slug' => 'top-10-ways-to-nap-in-the-train',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(7), 0, 6),
                'img' => '/img/driving.jpg',
                'title' => 'Top 10 ways to drive in style',
                'slug' => 'top-10-ways-to-drive-in-style',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
            [
                'id' => substr(md5(8), 0, 6),
                'img' => '/img/woods.jpg',
                'title' => 'Something amazing happened here',
                'slug' => 'something-amazing-happened-here',
                'summary' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                'date' => strtotime('-' . mt_rand(1, 24) . 'hours', time()),
            ],
        ];
    }

    public function getStoryById($storyId)
    {
        return array_reduce($this->data, function ($acc, $story) use ($storyId) {
            if ($story['id'] === $storyId) {
                return $story;
            }

            return $acc;
        });
    }

    public function getMainStory()
    {
        return array_merge([], $this->data[0], [
            'breaking' => true,
        ]);
    }

    public function getStories($limit = 10)
    {
        $data = array_slice($this->data, 1);

        shuffle($data);

        return array_slice($data, 0, $limit);
    }
}
