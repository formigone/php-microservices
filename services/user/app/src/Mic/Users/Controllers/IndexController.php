<?php

namespace Mic\Users\Controllers;

use Mic\Users\Services\UserService;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController implements ControllerProviderInterface
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $controller->post('/register', function (Request $req) {
            $username = $req->get('username');
            $password = $req->get('password');

            try {
                $res = $this->userService->register($username, $password);
            } catch (\Exception $exception) {
                return $this->error($exception->getMessage(), $exception->getCode());
            }

            return new JsonResponse(['success' => $res]);
        });

        $controller->get('/validate/{username}/{password}', function ($username, $password) {
            try {
                $res = $this->userService->validate($username, $password);
            } catch (\Exception $exception) {
                return $this->error($exception->getMessage(), $exception->getCode());
            }

            return new JsonResponse(['success' => $res]);
        });

        $controller->post('/change-password', function (Request $req) {
            $username = $req->get('username');
            $password = $req->get('password');
            $newPassword = $req->get('newPassword');

            try {
                $res = $this->userService->changePassword($username, $password, $newPassword);
            } catch (\Exception $exception) {
                return $this->error($exception->getMessage(), $exception->getCode());
            }

            return new JsonResponse(['success' => $res]);
        });

        return $controller;
    }

    private function error($message, $code)
    {
        return new JsonResponse([
            'error' => $message,
        ], $code);
    }
}
