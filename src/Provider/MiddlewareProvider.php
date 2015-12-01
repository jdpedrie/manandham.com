<?php namespace MH\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareProvider implements ServiceProviderInterface
{
    use ProviderTrait;

    public function register(Application $app)
    {
        $app->before(function (Request $request, Application $app) {
            if (
                explode('?', $request->getRequestUri())[0] === '/'
             || explode('?', $request->getRequestUri())[0] === '/not-found') {
                return;
            }

            $password = $request->request->get('founder');
            $cookie = $request->cookies->get('founder');

            $needsCookie = false;
            if (is_null($cookie)) {
                $needsCookie = true;
            }

            if (is_null($password)) {
                $password = $cookie;
            }

            $user = $app['password'];
            $isValidUser = in_array(strtolower($password), $user);

            $admin = strtolower($app['adminPassword']);

            if (!$isValidUser) {
                return new Response('', 301, [
                    'location' => '/?invalid'
                ]);
            }

            if ($password === $admin) {
                $app['isAdmin'] = true;
            }

            if ($needsCookie) {
                setcookie('founder', $password);
            }
        });
    }
}