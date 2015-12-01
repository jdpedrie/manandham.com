<?php namespace MH\Provider;

use League\Plates\Engine as Template;
use PDO;
use Silex\Application;
use Silex\ServiceProviderInterface;

class VendorProvider implements ServiceProviderInterface
{
    use ProviderTrait;

    public function register(Application $app)
    {
        $app['vendor.stripe'] = function($app) {
            return new \MH\Service\StripeService;
        };

        $app['vendor.plates'] = function() {
            return new Template(__DIR__ .'/../../views');
        };

        $app['pdo'] = function() {
            $dsn = sprintf(
                'mysql:host=%s:%d;dbname=%s',
                getenv('MYSQL_HOST'),
                getenv('MYSQL_PORT'),
                getenv('MYSQL_DB')
            );

            $pdo = new PDO(
                $dsn,
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASS'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

            return $pdo;
        };
    }
}