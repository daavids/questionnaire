<?php

use Symfony\Component\Dotenv\Dotenv;
use AltoRouter as Router;
use Twig\Loader\FilesystemLoader as TwigLoader;
use Twig\Environment as TwigEnvironment;

require_once __DIR__.'/paths.php';

$dotenv = new Dotenv();
$dotenv->load($paths['basepath'].'/.env');

// Set up Twig
$twigLoader = new TwigLoader($paths['templates']);
$twig = new TwigEnvironment($twigLoader, [
    'cache' => $paths['twigCache'],
    'auto_reload' => getenv('ENV') !== 'prod'
]);

// Set up routing
require_once __DIR__ .'/routes.php';

$router = new Router();
$router->addRoutes($routes);

$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}