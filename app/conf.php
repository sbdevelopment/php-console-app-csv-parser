<?php
define('HOMEDIR','C:/APACHE_SERVER/test1.ru');
define('SRC','/app/src/');
require HOMEDIR . '/app/autoload.php';
Psr4AutoloadClass::init(HOMEDIR . SRC);
header('Content-Type: application/json;charset="utf-8"');
error_reporting(0);
if(php_sapi_name() !== 'cli') {
    die('HERE IS NOT CLI');
} else {
    $file = $output = '';
    foreach ($argv as $item) {
        if (preg_match('/--file=/', $item)) {
            $file = preg_replace('/^--file=\'(.*)\'$/i', '$1', $item);
        } elseif (preg_match('/--output=/', $item)) {
            $output = str_replace('--output=', '', $item);
        }
    }
}