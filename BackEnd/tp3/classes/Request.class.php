<?php
class Request {

    public $controllerName;
    public $uriParameters;
    public $baseURI;

    public static function getCurrentRequest() {
        return new Request();
    }

    public function __construct() {
        $this->initBaseURI();
        $this->initControllerAndParametersFromURI();
    }

    protected function initBaseURI() {
        // Extract the base URI from SCRIPT_NAME (path to api.php)
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g., "/~luc.fabresse/api.php" or "/CDAW/api.php"
        $this->baseURI = dirname($scriptName); // e.g., "/~luc.fabresse" or "/CDAW"
        
        // Handle root case (if api.php is at the root)
        if ($this->baseURI === '/' || $this->baseURI === '\\') {
            $this->baseURI = '';
        }
    }

    protected function initControllerAndParametersFromURI() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // e.g., "/CDAW/BackEnd/tp3/api.php/users/1"
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g., "/CDAW/BackEnd/tp3/api.php"
        $basePath = dirname($scriptName); // e.g., "/CDAW/BackEnd/tp3"
        $resourcePath = substr($requestUri, strlen($basePath)); // e.g., "/api.php/users/1"
        if (strpos($resourcePath, '/api.php') === 0) {
            $resourcePath = substr($resourcePath, strlen('/api.php')); // e.g., "/users/1"
        }
        $segments = array_filter(explode('/', trim($resourcePath, '/'))); // e.g., ['users', '1']
        if (empty($segments)) {
            $this->controllerName = 'default';
            $this->uriParameters = [];
        } else {
            $this->controllerName = strtolower(array_shift($segments)); // 'users'
            $this->uriParameters = $segments; // ['1']
        }
    }

    public function getControllerName() {
        return $this->controllerName;
    }

    public function getHttpMethod() {
        return $_SERVER["REQUEST_METHOD"];
    }
    
}