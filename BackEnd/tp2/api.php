<?php
require "bootstrap.php";

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Extract the request path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = "/CDAW/BackEnd/tp2/api.php"; // Adjust based on your WAMP setup

// Remove base path to get the actual route
$route = str_replace($basePath, "", $uri);
$route = trim($route, "/");

// Example: "users" or "users/5"
$routeParts = explode("/", $route);

// Extract controller and optional ID
$controllerName = $routeParts[0] ?? null;
$resourceId = $routeParts[1] ?? null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($controllerName) {
    case 'users':
        $controller = new UsersController($requestMethod, $resourceId);
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}

$controller->processRequest();
?>
