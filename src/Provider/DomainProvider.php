<?php namespace MH\Provider;

use MH\Domain\Guest;
use MH\Domain\Transaction;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DomainProvider implements ServiceProviderInterface
{
    use ProviderTrait;

    public function register(Application $app)
    {
        $app['mh.domain.guest'] = function($app) {
            return new Guest\GuestRepository($app['pdo']);
        };

        $app['mh.domain.transaction'] = function($app) {
            return new Transaction\TransactionRepository(
                $app['pdo'],
                $app['vendor.stripe']
            );
        };
    }
}