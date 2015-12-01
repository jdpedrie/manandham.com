<?php namespace MH\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('/', function(Application $app, Request $request) {
            return $app['mh.controllers.base']->index($request);
        });

        $route->post('/guest', function(Application $app, Request $request) {
            return $app['mh.controllers.guest']->find($request);
        });

        $route->get('/pay/{id}', function(Application $app, Request $request, $id) {
            return $app['mh.controllers.guest']->payment($id);
        });

        $route->post('/process/{id}', function(Application $app, Request $request, $id) {
            return $app['mh.controllers.transaction']->pay($request, $id);
        });

        $route->get('/not-found', function(Application $app) {
            return $app['mh.controllers.guest']->notFound();
        });

        $route->get('/thank-you', function(Application $app) {
            return $app['mh.controllers.guest']->thanks();
        });

        $app->error(function (\Exception $e, $code) {
            if (404 == $code) {
                return new Response('', 301, [
                    'location' => '/'
                ]);
            }
        });

        return $route;
    }

    public function boot(Application $app)
    {}
}