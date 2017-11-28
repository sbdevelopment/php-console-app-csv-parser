<?php
// Constants
define('HOMEDIR','C:/APACHE_SERVER/test1.ru');
define('SRC','/app/src/');
define('SITE','http://test1.ru');

// PSR autoloader
require HOMEDIR . '/app/autoload.php';
Psr4AutoloadClass::init(HOMEDIR . SRC);