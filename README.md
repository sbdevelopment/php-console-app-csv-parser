## CSV Converter (CLI-app)

[![PHP](https://img.shields.io/badge/php-%5E7.1-green.svg)]()
[![PHPUit](https://img.shields.io/badge/phpunit-%5E6.4--dev-green.svg)]()
[![SymfonyYaml](https://img.shields.io/badge/Symfony--Yaml-%5E3.2-green.svg)]()

Экспортирует данные из CSV в формат, указанный в output.
Данные CSV соттветсвовать параметрам 

``Название Отеля string, URL string, рейтинг int(0-5)``

Как пользоваться:

```sh
$ php index.php --file='/path/to/file.csv' --output=json 
```
или
```sh
$ php index.php --tcp='127.0.0.1:80' --output=json 
```
Возможные варианты мода **output**:
* html
* xml
* json
* yml
