<?php

namespace ConsoleApp;

abstract class Reader
{
    private const TYPES = ['json','xml','yaml','sqlite','html'];

    /**
     * @var array
     */
    private $file_content;

    /**
     * Reader constructor.
     * @param string $path
     */
    final public function __construct($path)
    {
        $content = $this->readFile($path);
        if (is_array($content) && count($content)) {
            $this->setContent($content);
            return true;
        }
        return false;
    }

    /**
     * @param string $path
     * @return array|bool
     */
    abstract protected function readFile($path);

    /**
     * @param array $content
     */
    final protected function setContent($content)
    {
        foreach ($content as $item) {
            $this->file_content[] = $item;
        }
    }

    /**
     * @return array
     */
    final protected function getContent()
    {
        return $this->file_content;
    }

    /**
     * @param $array
     * @return array|bool
     */
    final protected function validateArrayData($array)
    {
        if (count($array)==3) {
            $name = $url = $stars = false;
            if (preg_match('/^(['.chr(0x7F).'-'.chr(0xff).'A-z\s0-9]+)$/i',$array[0])) {
                $name = $array[0];
            }
            if (preg_match('/^(http)?(s?)(\:\/\/)?([a-z0-9\-]{2,120})([a-z\.]{2,6})?(\/?)([\w0-9\.\?\=\;\&\%\/]+)?$/i',$array[1])) {
                $url = $array[1];
            }
            if ((int) $array[2] <= 5) {
                $stars = $array[2];
            }
            if ($name && $url && $stars) {
                return [
                    'name' => $name,
                    'url' => $url,
                    'stars' => $stars
                ];
            }
        }
        return false;
    }

    /**
     * @param array $content
     * @param string $output_type
     * @return string|bool
     */
    final protected function createLinkForContent($content, $output_type)
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

    /**
     * @param string $type
     * @return string
     */
    final public function output($type)
    {
        $errors = new Errors();
        if (in_array($type,self::TYPES)) {
            $content = $this->getContent();
            if(count($content)) {
                $url = SITE . '/get.php?f=' . $this->createLinkForContent($content, $type);
                return json_encode([
                    'success' => true,
                    'url' => $url
                ],true);
            } else {
                return $errors->getMessage(4);
            }
        }
        return $errors->getMessage(3);

    }
}