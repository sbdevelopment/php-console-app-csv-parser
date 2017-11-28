## CSV Converter (CLI-app)

[![PHP](https://img.shields.io/badge/php-%5E7.1-green.svg)]()
[![PHPUit](https://img.shields.io/badge/phpunit-%5E6.4--dev-green.svg)]()
[![SymfonyYaml](https://img.shields.io/badge/Symfony--Yaml-%5E3.2-green.svg)]()

Экспортирует данные из CSV в формат, указанный в output.
Данные CSV должны соответсвовать параметрам 

``Название Отеля string, URL string, рейтинг int(0-5)``

URL может содержать как полный адрес (с указанием протокола http/s) и параметрами, так и без указания протокола и параметров (domain.com)

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
