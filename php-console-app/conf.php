<?php
define('HOMEDIR','C:/APACHE_SERVER/test1.ru');
define('SRC','/php-console-app/src/');
require HOMEDIR . '/php-console-app/autoload.php';
Psr4AutoloadClass::init(HOMEDIR . SRC);
header('Content-Type: application/json;charset="utf-8"');
error_reporting(0);