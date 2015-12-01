<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

include __DIR__ . "/../vendor/autoload.php";

if (file_exists(__DIR__ ."/../.env")) {
    $dotenv = new Dotenv\Dotenv(__DIR__ ."/../");
    $dotenv->overload();
}

$app = new Silex\Application;

$app['debug'] = true;
$app['password'] = json_decode(getenv('USER_PASSWORD'));
$app['adminPassword'] = getenv('ADMIN_PASSWORD');
$app['isAdmin'] = false;
Stripe\Stripe::setApiKey(getenv("STRIPE_SECRET"));

$app->register(new MH\Provider\ControllerProvider);
$app->register(new MH\Provider\DomainProvider);
$app->register(new MH\Provider\MiddlewareProvider);
$app->register(new MH\Provider\VendorProvider);

$app->mount('/', new MH\Provider\RouteProvider);

$app->run();