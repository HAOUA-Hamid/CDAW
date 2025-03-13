<?php

require "config.php";

// Simple autoloader
spl_autoload_register(function ($class_name) {
    $classFile = $class_name . '.php';
    if (file_exists($classFile)) {
        include $classFile;
    }
});
