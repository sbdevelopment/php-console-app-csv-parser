<?php

namespace ConsoleApp\Generator;

use PHPUnit\Framework\TestCase;

class XMLTest extends TestCase
{
    private $valid_array;

    protected function setUp()
    {
        $this->valid_array = [
            [
                'name' => 'First Hotel',
                'url' => 'http://hotels.com/first',
                'stars'=> 4
            ],
            [
                'name' => 'Last Hotel',
                'url' => 'last-hotel.com',
                'stars'=> 3
            ],
            [
                'name' => 'Third Hotel',
                'url' => 'https://super.hotel/?utm_source=cli',
                'stars'=> 5
            ]
        ];
    }

    /**
     * Тестируем создание XML файла из валидного массива
     */
    public function testSavingInXml()
    {
        $xml = new XML();
        $result = $xml->saveContent($this->valid_array);
        echo $xml->getSavedFileName();
        self::assertTrue($result);
    }
}
