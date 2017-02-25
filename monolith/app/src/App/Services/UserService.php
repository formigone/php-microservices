<?php

namespace App\Services;

use App\Providers\UserProvider;

class UserService
{
    /** @var UserProvider */
    private $provider;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return array
     */
    public function getCurrentUser()
    {
        return $this->provider->getCurrentUser();
    }

    public function login($username, $password)
    {
        $res = $this->provider->validate($username, $password);

        if ($res) {
            $_SESSION['user'] = [
                'username' => $username,
            ];
        }

        return $res;
    }

    public function logout()
    {
        return session_destroy();
    }
}
