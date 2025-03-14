<?php
/*
 * Analyses a request, creates the right Controller passing it the request
 */
class Dispatcher {

    public static function dispatch($request) {
        return static::dispatchToController($request->getControllerName(), $request);
    }

    public static function dispatchToController($controllerName, $request) {
        // Capitalize the first letter and append 'Controller' to form the class name
        $controllerClass = ucfirst($controllerName) . 'Controller';

        // Check if the class exists (thanks to AutoLoader, it should be loaded if it exists)
        if (class_exists($controllerClass)) {
            return new $controllerClass($controllerName, $request);
        }

        // Fallback to DefaultController if the specified controller doesn't exist
        return new DefaultController('default', $request);
    }
}