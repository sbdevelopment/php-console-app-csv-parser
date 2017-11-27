<?php

namespace ConsoleApp\Generator;

use ConsoleApp\Generator;

class XML extends Generator
{
    protected function generateFromArray($array)
    {
        $count = count($array);
        if($count) {
            $xml = new \SimpleXMLElement('<hotels/>');
            foreach ($array as $i => $item) {
                $hotel = $xml->addChild('hotel');
                $hotel->addChild('name',$item['name']);
                $hotel->addChild('url',$item['url']);
                $hotel->addChild('stars',$item['stars']);
            }
            return $xml->asXML();
        }
        return false;
    }

    protected function getFileType()
    {
        return 'xml';
    }
}