<?php
require './php-console-app/conf.php';
$errors = new \ConsoleApp\Errors();
if(!empty($_GET['f'])) {
    $class_name = 'ConsoleApp\Generator\\' . str_replace('.','',strtoupper(substr($_GET['f'], -4, 4)));
    if (class_exists($class_name)) {
        $file = file_get_contents(HOMEDIR.'/dl/'.$_GET['f']);
        if(!empty($file)) {
            header('Pragma: no-cache');
            header('Content-Type: ' . mime_content_type(HOMEDIR.'/dl/'.$_GET['f']));
            header ("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            echo $file;
        }
    } else {
        echo $errors->getMessage(2);
    }
} else {
    echo $errors->getMessage(1);
}