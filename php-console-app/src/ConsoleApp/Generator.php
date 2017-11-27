<?php

namespace ConsoleApp;

abstract class Generator
{
    /**
     * @var string
     */
    private $file_name;

    abstract protected function generateFromArray($array);

    /**
     * @return string (html, xml, etc)
     */
    abstract protected function getFileType();

    /**
     * @param array $content
     * @return bool
     */
    final public function saveContent($content)
    {
        $path = HOMEDIR.'/dl/';
        $file_name = date('Ymd-Hi') . '-' . rand(111,999) . '.' . $this->getFileType();
        $handler = fopen($path . $file_name, 'w+');
        fwrite($handler, $this->generateFromArray($content));
        fclose($handler);
        if(is_file($path.$file_name)){
            $this->file_name = $file_name;
            return true;
        }
        return false;
    }

    final public function getSavedFileName(){
        if(!empty($this->file_name)){
            return $this->file_name;
        }
        return false;
    }

}