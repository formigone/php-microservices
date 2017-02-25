<?php

namespace App\Providers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ArticleProvider
{
    private $data;

    public function __construct()
    {
        $data = [
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

        $body = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
            'Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.',
            'Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
            'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?',
        ];

        $this->data = array_map(function ($row) use ($body) {
            $row['body'] = $body;
            return $row;
        }, $data);
    }

    /**
     * @param $storyId
     * @return mixed
     */
    public function getStoryById($storyId)
    {
        return array_reduce($this->data, function ($acc, $story) use ($storyId) {
            if ($story['id'] === $storyId) {
                return $story;
            }

            return $acc;
        });
    }

    /**
     * @return array
     */
    public function getMainStory()
    {
        return array_merge([], $this->data[0], [
            'breaking' => true,
        ]);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getStories($limit = 10)
    {
        $data = array_slice($this->data, 1);

        shuffle($data);

        return array_slice($data, 0, $limit);
    }

    /**
     * @return mixed
     */
    private function genRandomUser()
    {
        $users = [
            'proto',
            'roll',
            'rock',
            'drCossak',
            'drWylls',
            'eddie',
            'beatsy',
            'sparks',
            'magnettum',
        ];

        return $users[mt_rand(0, count($users) - 1)];
    }

    /**
     * @return array
     */
    private function genRandomParagraph()
    {
        $words = explode(' ', 'Similique sunt in culpa qui officia deserunt mollitia. animi, id, est laborum. et dolorum fuga officia deserunt mollitia animi id est dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam');
        $paragraphs = mt_rand(1, 5);
        $data = [];

        while ($paragraphs--) {
            $len = mt_rand(15, 25);
            $para = [];
            while ($len--) {
                $para[] = $words[mt_rand(0, count($words) - 1)];
            }
            $data[] = implode(' ', $para);
        }

        return $data;
    }

    /**
     * @param int $total
     * @param bool $hasChildren
     * @return array
     */
    public function genRandomComments($total = 1, $hasChildren = true)
    {
        $comments = [];

        for ($i = 0; $i < $total; $i++) {
            $totalChildren = mt_rand(1, 3);
            $children = [];

            if ($hasChildren) {
                $children = $this->genRandomComments($totalChildren, false);
            }

            $comments[] = [
                'author' => $this->genRandomUser(),
                'children' => $children,
                'text' => $this->genRandomParagraph()
            ];
        }

        return $comments;
    }
}
