<?php

namespace ConsoleApp\Reader;

use PHPUnit\Framework\TestCase;

class TCPTest extends TestCase
{
    private $tcp;
    private $path;
    private $output;
    private $pattern;

    protected function setUp()
    {
        $tcp = '167.0.0.1:80'; // ip:port
        $file = '/path/to/file.csv'; // /path/to/file.csv
        $this->path = $tcp . $file;
        $this->output = 'json'; // json, xml, html
        $this->tcp = new TCP($this->path);
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
        $array = $this->tcp->readFile($this->path);
        self::assertCount($count, $array);
    }

}
