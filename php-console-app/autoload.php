<?php

/**
 * Класс Psr4AutoloadClass. Основан на классе автозагручика, показанного как в пример реализации по стандарту PSR-4.
 *
 * @link http://www..org/psr/psr-4/ Стандарт
 * @see  https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md Пример реализации
 *       автозагрузчика по стандарту PSR-4
 */
abstract class Psr4AutoloadClass
{
    /**
     * Ассоциативный массив, где ключ - это префикс пространства имён, а значение - это массив путей основных
     * директорий с классами этого пространства имён.
     *
     * @var array $prefixes
     */
    protected static $prefixes = array();

    /** Директория содержащая директории пространств имён (по умолчанию ~src/) */
    protected static $namespacesDir = '';

    /**
     * Регистрирует автозагрузчик, а затем и пространств имён ищет все папки
     * соответствующие пространствам и регистрирует их в автозагрузчике.
     *
     * @param string $customDir Альтернативная директория к пространствам имён.
     */
    public static function init($customDir = null)
    {
        self::$namespacesDir = dirname(__FILE__).'/'.self::$namespacesDir;

        self::register();

        if (!is_dir(self::$namespacesDir) && (isset($customDir) && !is_dir($customDir))) {
            // Если директория по умолчанию не существует или альтернативная директория не существует, то
            // сбрасываем вывод и выводим сообщение об ошибке.
            ob_end_clean();
            die('Sorry. Lift not yet arrived.');
        }

        if (!empty($customDir)) {
            // Если задана альтернативная директория, то задаём её основной.
            self::$namespacesDir = str_replace('\\','/',$customDir);
        }

        // Извлекаем и регистрируем пространства имён и их директории в автозагрузчике.
        $namespaces = self::getDirNames();
        foreach ($namespaces as $namespace) {
            self::addNamespace($namespace, self::$namespacesDir . $namespace);
        }
    }

    /**
     * Регистрирет метод автозагрузчик класса с помощью SPL регистратора.
     *
     * @return void
     */
    protected static function register()
    {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * Привязывает директорию к префиксу пространства имён.
     *
     * @param string $prefix   Префикс пространства имён.
     * @param string $base_dir Директория содержая файлы классов данного пространства имён.
     * @param bool   $prepend  Есди true, добавляет в начало стека, если false, то в конец. Влияет на скорость поиска
     *                         классов в даннои пространстве имён
     *
     * @return void
     */
    protected static function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // Нормализуем префикс.
        $prefix = trim($prefix, '\\') . '\\';

        // Нормализуем директорию.
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        // Инициализирум массив директорий для данного префикса.
        if (isset(self::$prefixes[$prefix]) === false) {
            self::$prefixes[$prefix] = array();
        }

        // Сохраняем директорию в массив префикса.
        if ($prepend) {
            array_unshift(self::$prefixes[$prefix], $base_dir);
        } else {
            array_push(self::$prefixes[$prefix], $base_dir);
        }
    }

    /**
     * Загружает файл класса для полученного имени класса.
     *
     * @param string $class Полное имя класса
     *
     * @return mixed Если успех - то выводит файл класса. Если нет, то false.
     */
    protected static function loadClass($class)
    {
        // Текущий префикс пространства имён.
        $prefix = $class;

        // Работает в обратном направлении, чтобы найти имя класса ведущего к существующему файлу с его определением.
        while (false !== $pos = strrpos($prefix, '\\')) {

            // Сохраняет разделитель пространства имён в префиксе.
            $prefix = substr($class, 0, $pos + 1);

            // Всё прочее будет относительным именем класса.
            $relative_class = substr($class, $pos + 1);

            // Пытается загрузить файл по префиксу и относительному имени.
            $mapped_file = self::loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }

            // Удаляет разделитель из префикса для следующей итерации.
            $prefix = rtrim($prefix, '\\');
        }

        // Не удалось найти файл класса.
        return false;
    }

    /**
     * Загружает файт по его перфиксу пространства имён и относительному имени.
     *
     * @param string $prefix         Префикс пространства имён.
     * @param string $relative_class Относительное имя класса.
     *
     * @return mixed False если файл не может быть загружен, либо имя файла который будет загружен.
     */
    protected static function loadMappedFile($prefix, $relative_class)
    {
        // Существует ли диррекория пространства имён с таким префиксом.
        if (isset(self::$prefixes[$prefix]) === false) {
            return false;
        }

        // Смотрим через это пространство имён в поисках нужной директории.
        foreach (self::$prefixes[$prefix] as $base_dir) {

            // Заменяем префикс директорией, разделитель пространств имён - разделителем директорий, к
            // относительному имени класса добавляем расширение .php
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // Если запрашиваемый файл существет, требуем его загрузки.
            if (self::requireFile($file)) {
                // ДА. Мы сделали это.
                return $file;
            }
        }

        // Файл не был найден.
        return false;
    }

    /**
     * Если файл существует, требует его загрузки из файловой системы.
     *
     * @param string $file Файл для загрузки.
     *
     * @return bool True - если файл существет, false - если нет.
     */
    protected static function requireFile($file)
    {
        if (file_exists($file)) {
            /** @noinspection PhpIncludeInspection */
            require $file;

            return true;
        }

        return false;
    }

    /**
     * По умолчанию из директории пространств имён возвращает массив с именами всех папок.
     * Эти имена должны соответствовать используемым пространствам имён.
     *
     * @return array Массив префиксов пространств имён.
     */
    protected static function getDirNames()
    {
        // Сканируем основную директорию на наличие файлов и каталогов
        $files = scandir(self::$namespacesDir);
        $directories = array();
        foreach ($files as $file) {
            // В массив префиксов записываем только имена каталогов, расположенных непосредственно в основной
            // директории.
            if (is_dir(self::$namespacesDir . $file) && $file != '.' && $file != '..') {
                $directories[] = $file;
            }
        }
        return $directories;
    }
}