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

    private function openSocket($tcp)
    {
        $reg_ip = '([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})';
        $reg_port = '([0-9]{2,5})';
        $reg_file = '(.*)';
        $regular = '/^'.$reg_ip.'\:'.$reg_port.'[/]'.$reg_file.'$/i';

        $ip = preg_replace($regular,'$1.$2.$3.$4',$tcp);
        $port = preg_replace($regular,'$5',$tcp);
        $file = preg_replace($regular, '$6',$tcp);

        if(preg_match('/^'.$reg_ip.'$/i', $ip) && preg_match('/^'.$reg_port.'$/', $reg_port) && !empty($file)) {
            return fsockopen($ip.$file, $port);
        }
        return false;
    }
}