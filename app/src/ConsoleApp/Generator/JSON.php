<?php

namespace ConsoleApp\Generator;

use ConsoleApp\Generator;

class JSON extends Generator
{
    protected function generateFromArray($array)
    {
        $count = count($array);
        if($count) {
            $hotels = [];
            foreach ($array as $item){
                $name = $item['name'];
                $hotels[][$name] = [
                    'url' => $item['url'],
                    'stars' => $item['stars']
                ];
            }
            $json['hotels'] = $hotels;
            return json_encode($json, true);
        }
        return false;
    }

    protected function getFileType()
    {
        return 'json';
    }
}