<?php
/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
|
| Here you can list below all routes used by your application 
|
| Examples :
|
| Add a single route : 
|
| $router->add('/hello', 'index::hello');
|
| 	-> Will execute indexController and helloAction method
| 
| Name the route :
|
| $router->add('/hello', 'index::hello')->setName('hello-world');
| 
|--------------------------------------------------------------------------
| For more details about the routing system : 
| @link http://docs.phalconphp.com/en/latest/reference/routing.html
| 
*/
$router->add('/', 'hello::index');

$router->addGet("/api/:params", array(
        "controller" => "Api",
        "action"     => "getEndpoint",
        "params"     => 1,
));

$router->addPost("/api/:params", array(
        "controller" => "Api",
        "action"     => "postEndpoint",
        "params"     => 1,
));

$router->addPut("/api/:params", array(
        "controller" => "Api",
        "action"     => "putEndpoint",
        "params"     => 1,
));

$router->addDelete("/api/:params", array(
        "controller" => "Api",
        "action"     => "deleteEndpoint",
        "params"     => 1,
));
