<?php
require 'bootstrap.php';
// Return json in console
header('Content-Type: application/json;charset="utf-8"');
// Errors off
error_reporting(0);
// Config params
$file = $output = $sort = $tcp = false;

if(php_sapi_name() !== 'cli' && $_SERVER['SCRIPT_NAME'] !== '/get.php') {
    die('HERE IS NOT CLI');
}
else {
    // Get params
    foreach ($argv as $item) {
        if (preg_match('/--file=/', $item)) {
            $file = preg_replace('/^--file=\'(.*)\'$/i', '$1', $item);
        } elseif (preg_match('/--output=/', $item)) {
            $output = str_replace('--output=', '', $item);
        } elseif (preg_match('/--sort=/', $item)) {
            $sort = str_replace('--sort=', '', $item);
        } elseif (preg_replace('/^--tcp=\'(.*)\s(.*)\'$/', '$1:$2',$item)) {
            $tcp = preg_match('/^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})\:([0-9]{2,5})$/i',$item) ? $item : false;
            if(!$tcp) {
                $tcp = preg_match('/^([a-z\-]+)\.([a-z]{2,6})\:([0-9]{2,5})$/i',$item) ? $item : false;
            }
        }
    }
}