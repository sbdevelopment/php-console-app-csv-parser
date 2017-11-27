<?php
define('HOMEDIR','C:/APACHE_SERVER/test1.ru');
define('SRC','/app/src/');
require HOMEDIR . '/app/autoload.php';
Psr4AutoloadClass::init(HOMEDIR . SRC);
header('Content-Type: application/json;charset="utf-8"');
error_reporting(0);