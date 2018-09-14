Platron Shtrih-m SDK
===============
## Установка

Проект предполагает через установку с использованием composer
<pre><code>composer require payprocessing/shtrih-m</pre></code>

## Тесты
Для работы тестов необходим PHPUnit, для установки необходимо выполнить команду
```
composer require phpunit/phpunit
```
Для того, чтобы запустить интеграционные тесты нужно скопировать файл tests/integration/MerchantSettingsSample.php удалив 
из названия Sample и вставив настройки магазина. Так же в папку tests/integration/merchant_data необходимо положить приватный
ключ. После выполнить команду из корня проекта
```
vendor/bin/phpunit tests/integration
```

## Примеры использования смотри в интеграционном тесте
https://github.com/Platron/shtrih-m/blob/master/tests/integration/