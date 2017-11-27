<?php
require './app/conf.php';
$errors = new \ConsoleApp\Errors();
if(!empty($_REQUEST['file']) && !empty($_REQUEST['output'])) {

    $file = trim($_REQUEST['file']);
    $class_name = '\ConsoleApp\Reader\\' . strtoupper(substr($file, -3, 3));

    if (class_exists($class_name)) {
        echo (new $class_name($file))->output($_REQUEST['output']);
    } else {
        echo $errors->getMessage(2);
    }
} else {
    echo $errors->getMessage(1);
}