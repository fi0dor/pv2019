<?php

    spl_autoload_register(function (String $class) { 
        $filePath = str_replace("\\", DIRECTORY_SEPARATOR, $class); 
        
        if (file_exists($filePath . '.php')) {
            require $filePath . '.php';
        } else {
            echo '<h2>Autoload.php</h2>';
            echo 'File <b>' . APP_ROOT . $filePath . '.php </b> not found in predefined directories';
            exit();
        }
    });

?>