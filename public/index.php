<?php
require_once '../app/core/Router.php';
use App\Core\Router;
$router = new Router();
$router->add('GET', '/students', 'StudentController', 'index');
$router->add('GET', '/students/create', 'StudentController', 'create');
$router->add('GET', '/students/{id}', 'StudentController', 'show');
$router->add('GET', '/students/{id}/edit', 'StudentController', 'edit');

$router->add('POST', '/students', 'StudentController', 'store');
$router->add('PUT','/students/{id}','Studentcontroller','update');
$router->add('DELETE','/students/{id}','Studentcontroller','destroy');

$router->run();
?>