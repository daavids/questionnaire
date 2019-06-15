<?php

use Symfony\Component\Dotenv\Dotenv;
use AltoRouter as Router;
use Twig\Loader\FilesystemLoader as TwigLoader;
use Twig\Environment as TwigEnvironment;
use Twig\TwigTest;
use App\Helpers\Database;

require_once __DIR__.'/paths.php';

// Set up Dotenv
$dotenv = new Dotenv();
$dotenv->load($paths['basepath'].'/.env');


// Set up Twig
$twigLoader = new TwigLoader($paths['templates']);
$twig = new TwigEnvironment($twigLoader, [
    'cache' => $paths['twigCache'],
    'auto_reload' => getenv('ENV') !== 'prod'
]);

// Set up DB connection
$db = new Database(getenv('DB_HOST'), getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
$connected = $db->connect();
if (!$connected) {
    echo $twig->render('default.htm', [
        'page' => 'pages/error.htm',
        'error' => 'Could not establish a connection to the database.',
        'title' => 'Error'
        ]
    );
    return;
}

// Add auth check to Twig
$authTest = new TwigTest('auth', function () {
    return true;
});
$twig->addTest($authTest);

// Set up routing
require_once __DIR__.'/routes.php';
$router = new Router();
$router->addRoutes($routes);

$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}