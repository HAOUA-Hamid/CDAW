<?php
require "bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function getRoute($url) {
    $url = trim($url, '/');
    $urlSegments = explode('/', $url);

    $scheme = ['controller', 'params'];
    $route = [];

    foreach ($urlSegments as $index => $segment) {
        if ($scheme[$index] == 'params') {
            $route['params'] = array_slice($urlSegments, $index);
            break;
        } else {
            $route[$scheme[$index]] = $segment;
        }
    }

    return $route;
}

$uri = $_GET['request'] ?? ''; 
$route = getRoute($uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$controllerName = $route['controller'] ?? null;

switch ($controllerName) {
    case 'users':
        $controller = new UsersController($requestMethod);
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}

$controller->processRequest();
