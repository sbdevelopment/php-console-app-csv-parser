<?php

namespace ConsoleApp\Reader;

use ConsoleApp\Reader;

class TCP extends Reader
{

    public function readFile($tcp)
    {
        $handler = $this->openSocket($tcp);
        if ($handler){
            if(count(fgetcsv($handler,2500,','))) {
                $content = [];
                while (($data = fgetcsv($handler, 2500, ',')) !== false) {
                    $valid_data = $this->validateArrayData($data);
                    if ($valid_data) {
                        $content[] = $valid_data;
                    }
                }
                return $content;
            }
        }
        return false;
    }

    public function openSocket($tcp)
    {
        $reg_host = '([a-z\-]+)\.([a-z]{2,6})';
        $reg_port = '([0-9]{2,5})';
        $reg_file = '(.*)';
        if(!preg_match('/^'.$reg_host.'\:'.$reg_port.'[\/]'.$reg_file.'$/i',$tcp)) {
            $reg_host = '([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})';
            $regular = '/^'.$reg_host.'\:'.$reg_port.'[\/]'.$reg_file.'$/i';
            $host = preg_replace($regular, '$1.$2.$3.$4', $tcp);
            $port = preg_replace($regular, '$5', $tcp);
            $file = preg_replace($regular, '$6', $tcp);
        } else {
            $regular = '/^'.$reg_host.'\:'.$reg_port.'[\/]'.$reg_file.'$/i';
            $host = preg_replace($regular,'$1.$2',$tcp);
            $port = preg_replace($regular, '$3', $tcp);
            $file = preg_replace($regular, '$4', $tcp);
        }
        if (preg_match('/^' . $reg_host . '$/i', $host) && preg_match('/^' . $reg_port . '$/', $port) && !empty($file)) {
            return fsockopen($host . $file, $port);
        }
        return false;
    }
}