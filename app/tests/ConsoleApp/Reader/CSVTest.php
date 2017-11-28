<?php

namespace ConsoleApp\Reader;

use PHPUnit\Framework\TestCase;

class CSVTest extends TestCase
{
    private $csv;
    private $path;
    private $output;
    private $pattern;

    protected function setUp()
    {
        $this->path = 'C:/APACHE_SERVER/test1.ru/test.csv'; // /path/to/file.csv
        $this->output = 'json'; // json, xml, html
        $this->csv = new CSV($this->path);
        $this->pattern = '/^\{\"success\"\:true\,\"url\"\:\"http(s?)([\:\\/\\/]+)(.*)([\\/]+)get.php\?f\=([0-9\-\.a-z]+)\"\}$/i';
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
        self::assertCount($count, $array);
    }
}
