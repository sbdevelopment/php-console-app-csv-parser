<?php

namespace ConsoleApp\Generator;

use PHPUnit\Framework\TestCase;

class HTMLTest extends TestCase
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
     * Тестируем создание HTML файла из валидного массива
     */
    public function testSavingInHtml()
    {
        $html = new HTML();
        $result = $html->saveContent($this->valid_array);
        echo $html->getSavedFileName();
        self::assertTrue($result);
    }
}
