Platron Shtrih-m SDK
===============
## BREAKING CHANGES !!!
* Класс AdditionalAttribute переименован в AdditionalUserAttribute.
* Свойство additionalAttribute из класса Customer перенесено в класс CreateReceiptRequest с названием additionalUserAttribute
* Свойства phone и email из класса Customer перенесены в класс CreateReceiptRequest


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
tests/integration