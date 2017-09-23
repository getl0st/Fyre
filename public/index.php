<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);
header('Content-Type: text/html; charset=utf-8');
require APP . 'core/application.php';
require APP . 'core/model.php';
require APP . 'core/controller.php';

require APP . 'config/config.php';
require APP . 'config/routes.php';

use Fyre\Core\Application;

$app = new Application();

$app->addHook("404", function() {
    
    echo "Page not found";
});
$app->serve($routes);
