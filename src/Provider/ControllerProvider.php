<?php namespace MH\Provider;

use MH\Controller;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerProvider implements ServiceProviderInterface
{
    use ProviderTrait;

    public function register(Application $app)
    {
        $app['mh.controllers.base'] = $app->share(function($app) {
            return new Controller\BaseController(
                $app['vendor.plates']
            );
        });

        $app['mh.controllers.guest'] = $app->share(function($app) {
            return new Controller\GuestController(
                $app['mh.domain.guest'],
                $app['vendor.plates'],
                $app['isAdmin']
            );
        });

        $app['mh.controllers.transaction'] = $app->share(function($app) {
            return new Controller\TransactionController(
                $app['mh.domain.transaction'],
                $app['mh.domain.guest'],
                $app['vendor.plates'],
                $app['isAdmin']
            );
        });
    }
}