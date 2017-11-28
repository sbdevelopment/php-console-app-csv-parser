<?php
/**
 * Created by PhpStorm.
 * User: 79386
 * Date: 28.11.2017
 * Time: 15:16
 */

namespace ConsoleApp\Generator;

use PHPUnit\Framework\TestCase;

class JSONTest extends TestCase
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
     * Тестируем создание JSON файла из валидного массива
     */
    public function testSavingInJson()
    {
        $json = new JSON();
        $result = $json->saveContent($this->valid_array);
        echo $json->getSavedFileName();
        self::assertTrue($result);
    }
}
