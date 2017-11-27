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

    /**
     * @param array $content
     * @param string $output_type ! добавить в use все доступные классы
     * @return string|bool
     */
    protected function createLinkForContent($content, $output_type)
    {
        $type = strtoupper(trim($output_type));
        $class_name = 'ConsoleApp\Generator\\' . $type;
        if (class_exists($class_name)) {
            $generator = new $class_name();
            if ($generator->saveContent($content)) {
                return $generator->getSavedFileName();
            }
        }
        return false;
    }
}