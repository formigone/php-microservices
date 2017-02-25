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
}
