<?php

session_start();

$routes = require 'config/routes.php';

$uri = $_SERVER['REQUEST_URI'];

if(!array_key_exists($uri, $routes)) {
	return http_response_code(404);
}

$method = $routes[$uri][0];
$controller = $routes[$uri][1];
$action = $routes[$uri][2];

require_once('controllers/' . $controller . '.php');

$controller = new $controller($method);
$controller->$action();