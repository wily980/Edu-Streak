<?php
session_start();

require_once '../app/core/Router.php';
use App\Core\Router;

$router = new Router();

// Auth routes
$router->add('GET', '/auth/google', 'AuthController', 'redirectToGoogle');
$router->add('GET', '/auth/google/callback', 'AuthController', 'handleGoogleCallback');

// Student routes
$router->add('GET', '/students', 'StudentController', 'index');
$router->add('GET', '/students/create', 'StudentController', 'create');
$router->add('GET', '/students/{id}', 'StudentController', 'show');
$router->add('GET', '/students/{id}/edit', 'StudentController', 'edit');
$router->add('POST', '/students', 'StudentController', 'store');
$router->add('PUT', '/students/{id}', 'StudentController', 'update');
$router->add('DELETE', '/students/{id}', 'StudentController', 'destroy');
$router->add('GET', '/', 'AuthController', 'login'); 
$router->add('GET', '/learn', 'LanguageController', 'index');
$router->add('POST', '/learn', 'LanguageController', 'store');

$router->run();
?>