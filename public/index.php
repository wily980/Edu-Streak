<?php
session_start();

require_once '../app/core/Router.php';
use App\Core\Router;

$router = new Router();

// Auth
$router->add('GET', '/auth/google', 'AuthController', 'redirectToGoogle');
$router->add('GET', '/auth/google/callback', 'AuthController', 'handleGoogleCallback');

// Leaderboard
$router->add('GET', '/leaderboard', 'LeaderboardController', 'index');

// Level
$router->add('GET', '/level', 'LevelController', 'index');

// Preference
$router->add('GET',  '/preference', 'PreferenceController', 'index');
$router->add('POST', '/preference', 'PreferenceController', 'store');


// Learn (language picker)
$router->add('GET', '/learn', 'LanguageController', 'index');
$router->add('POST', '/learn', 'LanguageController', 'store');

// Shop
$router->add('GET', '/students/shop', 'ShopController', 'index');
$router->add('POST', '/shop/buy', 'ShopController', 'buy');

// Students — specific routes BEFORE wildcards
$router->add('GET', '/students', 'StudentController', 'index');
$router->add('GET', '/students/create', 'StudentController', 'create');
$router->add('GET', '/students/{slug}/levels', 'StudentController', 'levels');
$router->add('GET', '/students/{id}/edit', 'StudentController', 'edit');
$router->add('POST', '/students', 'StudentController', 'store');
$router->add('PUT', '/students/{id}', 'StudentController', 'update');
$router->add('DELETE', '/students/{id}', 'StudentController', 'destroy');
$router->add('GET', '/students/{id}', 'StudentController', 'show');

// Landing
$router->add('GET', '/', 'AuthController', 'login');

$router->run();
?>