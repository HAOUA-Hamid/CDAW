<?php
class AutoLoader {

public function __construct() {
    spl_autoload_register(array($this, 'load'));
}

private function load($className) {
    // Define possible directories where class files might be located
    $directories = [
        __ROOT_DIR . '/classes/',
        __ROOT_DIR . '/model/',
        __ROOT_DIR . '/controller/'
    ];

    // Loop through each directory to find the class file
    foreach ($directories as $directory) {
        $filePath = $directory . $className . '.class.php';
        if (is_readable($filePath)) {
            require_once $filePath;

            // If the class is in the model directory, load its SQL file too
            if ($directory === __ROOT_DIR . '/model/') {
                $sqlFilePath = __ROOT_DIR . '/sql/' . $className . '.sql.php';
                if (is_readable($sqlFilePath)) {
                    require_once $sqlFilePath;
                }
            }
            return; // Exit once the file is found and loaded
        }
    }

    // Optional: Throw an exception if the class file is not found (for debugging)
    // throw new Exception("Class $className not found in any directory.");
}
}

$__LOADER = new AutoLoader();