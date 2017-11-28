<?php

namespace ConsoleApp\Generator;

use ConsoleApp\Generator;

class YML extends Generator
{
    /**
     * @param array $array
     * @return string
     */
    final protected function generateFromArray($array)
    {
        $count = count($array);
        if($count) {
            $hotels = [
                'hotels' => $array
            ];
            return \Symfony\Component\Yaml\Yaml::dump($hotels);
        }
        return false;
    }

    /**
     * @return string
     */
    final protected function getFileType()
    {
        return 'yml';
    }
}