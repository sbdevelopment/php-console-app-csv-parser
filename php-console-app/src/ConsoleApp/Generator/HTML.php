<?php

namespace ConsoleApp\Generator;

use ConsoleApp\Generator;

/**
 * Class HTML
 * @package ConsoleApp\Generator
 */
class HTML extends Generator
{
    /**
     * @param array $array
     * @return string
     */
    final protected function generateFromArray($array)
    {
        $count = count($array);
        if($count) {
            $generated = file_get_contents(HOMEDIR . '/tpl/header.html') . "\n";
            foreach ($array as $i => $item) {
                $generated .= '<div class="line">'
                    . '<div>' . $item['name'] . '</div><div>' . $item['url'] . '</div><div>' . $item['stars'] . '</div>';
                $generated .= '</div>' . "\n";
            }
            $generated .= "\n" . '<div class="count">Всего записей:' . $count .'</div>';
            $generated .= "\n" . file_get_contents(HOMEDIR . '/tpl/footer.html');
            return $generated;
        }
        return false;
    }

    /**
     * @return string
     */
    final protected function getFileType()
    {
        return 'html';
    }
}