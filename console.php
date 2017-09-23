<?php

function clear() {
    
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}
clear();

echo " _____                            ____                                 _       \n";
echo "|  ___|  _   _   _ __    ___     / ___|   ___    _ __    ___    ___   | |   ___ \n";
echo "| |_    | | | | | '__|  / _ \   | |      / _ \  | '_ \  / __|  / _ \  | |  / _ \ \n";
echo "|  _|   | |_| | | |    |  __/   | |___  | (_) | | | | | \__ \ | (_) | | | |  __/  \n";
echo "|_|      \__, | |_|     \___|    \____|  \___/  |_| |_| |___/  \___/  |_|  \___|   \n";
echo "         |___/                                                                      \n";
                                                                                       
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

if (isset($argv[1])) {
    
    switch ($argv[2]) {
        case 'model':
            create_model($argv[3]);
            break;
        case 'controller':
            create_controller($argv[3]);
            break;
        case 'help':
            help();
            break;
        default:
            error('This command is not supported: ' . $argv[2] . ". Try this command: php console.php get help.");
            break;
    }
    
} else {
    
    error('Arguments not supplied');
}

function create_model($name = "") {
    
    if (empty($name) || !isset($name)) {
        
        error('You must name your model.');
    } else {
        
        $file_location = APP . "model/" . $name . ".php";
        $model = fopen($file_location, "w") or error('Cannot create file.');
        $model_code = "<?php \n\n/** \n* Model " . $name . " \n*\n*\n**/\n\nnamespace Fyre\Model;\n\nclass " . $name . " extends \Fyre\Core\Model {\n\n   function getHello() {\n\n        echo 'hello';\n    }\n}";
        fwrite($model, $model_code);
        fclose($model);
        if (file_exists($file_location)) {
            
            echo "\n\n|| Model created successfully. At: " . $file_location . ". Remember to require/include your model where you need it.";
        } 
    }
}

function create_controller($name = "") {
    
    if (empty($name) || !isset($name)) {
        
        error('You must name your controller.');
    } else {
        
        $file_location = APP . "controllers/" . $name . ".controller.php";
        $controller = fopen($file_location, "w") or error('Cannot create file.');
        $controller_code = "<?php \n\n/** \n* Controller " . $name . " \n*\n*\n**/\n\nnamespace Fyre\Controller;\n\nclass " . $name . " extends \Fyre\Core\Controller {\n\n   function index() {\n\n        echo 'hello';\n    }\n}";
        fwrite($controller, $controller_code);
        fclose($controller);
        if (file_exists($file_location)) {
            
            echo "\n\n|| Controller created successfully. At: " . $file_location;
        } 
    }
}

function help() {
    
    clear();
    echo " _   _   _____   _       ____  \n";
    echo "| | | | | ____| | |     |  _  \ \n";
    echo "| |_| | |  _|   | |     | |_) |  \n";
    echo "|  _  | | |___  | |___  |  __/    \n";
    echo "|_| |_| |_____| |_____| |_|        \n";
    
    echo "\n\n\n";
    echo "|| Curently we have 2 commands:\n";
    echo "      - create controller [name]\n";
    echo "      - create model [name]\n";
}

function error($message = "") {
    
    echo "|| And error occured. ". $message . "\n"; 
    exit();
}


echo "\n";
echo "\n";
echo "\n";
echo "\n";

?>