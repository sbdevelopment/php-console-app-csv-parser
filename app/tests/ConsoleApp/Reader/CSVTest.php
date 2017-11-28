<?php

namespace ConsoleApp\Reader;

use PHPUnit\Framework\TestCase;

class CSVTest extends TestCase
{
    private $csv;
    private $path;

    protected function setUp()
    {
        $this->path = 'C:/APACHE_SERVER/test1.ru/test.csv'; // /path/to/file.csv
        $this->csv = new CSV($this->path);
    }

    /**
     * Тестирование чтения csv-файла, которое после успешного чтения
     * проверяет массив на валидность значений элементов и возвращает
     * валидные данные массива
     */
    public function testReadFile()
    {
        $count = 3; // Ожидаемое кол-во элементов массива
        $array = $this->csv->readFile($this->path);
        if(!$array) {
            $array = [];
        }
        self::assertCount($count, $array);
    }
}
