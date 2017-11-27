<?php
require './app/conf.php';
$errors = new \ConsoleApp\Errors();
if(!empty($file) && !empty($output)) {

    $file = trim($file);
    $class_name = '\ConsoleApp\Reader\\' . strtoupper(substr($file, -3, 3));

    if (class_exists($class_name)) {
        echo (new $class_name($file))->output($output);
    } else {
        echo $errors->getMessage(2);
    }
} else {
    echo $errors->getMessage(1);
}