<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/../cuiotkiosk/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('switch', ['controller' => 'Iot', 'action' => 'switch']);
$router->add('switches', ['controller' => 'Iot', 'action' => 'switches']);
$router->add('settings', ['controller' => 'Iot', 'action' => 'settings']);
$router->add('subscribe', ['controller' => 'Iot', 'action' => 'subscribe']);
$router->add('setsub', ['controller' => 'Iot', 'action' => 'setsub']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);

// /^[a-zA-Z0-9._-]/