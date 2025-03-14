<?php

    // define __ROOT_DIR constant which contains the absolute path on disk
    // of the directory that contains this file (api.php)
    $rootDirectoryPath = realpath(dirname(__FILE__));
    define('__ROOT_DIR', $rootDirectoryPath);

    // Load all application config
    require_once(__ROOT_DIR . "/config/config.php");

    // Load the Loader class to automatically load classes when needed
    require_once(__ROOT_DIR . '/classes/AutoLoader.class.php');

    // Reify the current request
    $request = Request::getCurrentRequest();
    Response::interceptEchos();
    try {
        $controller = Dispatcher::dispatch($request);
        $response = $controller->execute();
    } catch (Exception $e) {
        $log = Response::getEchos();
        $log .= " " . $e->getMessage();
        $response = Response::errorResponse($log);
    }

    $response->send();