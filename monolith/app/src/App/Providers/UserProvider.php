<?php

namespace App\Providers;

use GuzzleHttp\Client;

class UserProvider
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getCurrentUser()
    {
        return array_key_exists('user', $_SESSION) ? $_SESSION['user'] : [];
    }

    public function validate($username, $password)
    {
        try {
            $res = $this->client->request('GET', 'http://serv_users:8080/validate/' . $username . '/' . $password);
        } catch (\Exception $e) {
            return false;
        }

        $json = json_decode($res->getBody(), true);
        return $json['success'];
    }
}
