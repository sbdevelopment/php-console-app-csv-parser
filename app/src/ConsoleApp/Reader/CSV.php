<?php

namespace ConsoleApp\Reader;

use ConsoleApp\Reader;

/**
 * Class CSV
 * @package ConsoleApp\Reader
 */
class CSV extends Reader
{
    /**
     * @param string $path
     * @return array|bool
     */
    protected function readFile($path)
    {
        if (is_file($path) && in_array(mime_content_type($path),['text/csv','text/plain'])){
            $content = [];
            $handler = fopen($path,'r');
            while(($data = fgetcsv($handler,2500,','))!==false){
                $valid_data = $this->validateArrayData($data);
                if($valid_data){
                    $content[] = $valid_data;
                }
            }
            fclose($handler);
            return $content;
        }
        return false;
    }
}