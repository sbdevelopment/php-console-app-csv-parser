<?php

namespace ConsoleApp\Reader;

use ConsoleApp;

class TCP extends CSV
{

    protected function readFile($tcp)
    {
        $regular = '/^(\d+).(\d+).(\d+).(\d+)\:(\d+)/i';

        $ip = preg_replace($regular,'$1.$2.$3.$4',$tcp);
        $port = preg_replace($regular,'$5',$tcp);

        $handler = fsockopen($ip,$port);
        if ($handler){
            $content = [];
            while(($data = fgetcsv($handler,2500,','))!==false){
                $valid_data = $this->validateArrayData($data);
                if($valid_data){
                    $content[] = $valid_data;
                }
            }
            return $content;
        }
        return false;
    }

}