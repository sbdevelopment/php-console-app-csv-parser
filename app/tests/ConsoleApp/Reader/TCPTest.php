<?php

namespace ConsoleApp\Reader;

use PHPUnit\Framework\TestCase;

class TCPTest extends TestCase
{
    private $tcp;
    private $path;

    protected function setUp()
    {
        $tcp = '127.0.0.1:80'; // ip:port
        $file = '/test.csv'; // /path/to/file.csv
        $this->path = $tcp . $file;
        $this->tcp = new TCP($this->path);
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
        if(!$array) {
            $array = [];
        }
        self::assertCount($count, $array);
    }

}
