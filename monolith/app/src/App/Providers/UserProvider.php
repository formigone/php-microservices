<?php

namespace App\Providers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class UserProvider
{
    private $data;

    public function __construct()
    {
        $data = [
            'username' => 'roco',
        ];

        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getCurrentUser()
    {
        return $this->data;
    }
}
