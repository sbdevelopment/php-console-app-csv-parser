<?php

namespace ConsoleApp;

class Errors
{
    public function getMessage($id)
    {
        switch ($id) {
            case 1:
                $message = 'Не переданы необходимые параметры.';
                break;
            case 2:
                $message = 'Не удалость прочесть файл.';
                break;
            case 3:
                $message = 'К сожалению, подготовить файл в переданном формате в данный момент нельзя.';
                break;
            case 4:
                $message = 'Ошибка получения данных.';
                break;
        }
        if(!empty($message)) {
            $error = [
                'error' => $message,
                'err_num' => $id
            ];
        }
        else {
            $error = [
                'error' => 'Не известный тип ошибки.',
                'err_num' => $id
            ];
        }
        return json_encode($error,true);
    }
}