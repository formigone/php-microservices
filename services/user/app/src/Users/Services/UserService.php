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
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function validate($username, $password)
    {
        return $this->provider->validate($username, $password);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function register($username, $password)
    {
        return $this->provider->register($username, $password);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($username, $password, $newPassword)
    {
        return $this->provider->changePassword($username, $password, $newPassword);
    }
}
