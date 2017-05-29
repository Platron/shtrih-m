Platron Shtrih-m SDK
===============
## Установка

Проект предполагает через установку с использованием composer

## Тесты
Для работы тестов необходим PHPUnit, для установки необходимо выполнить команду
```
composer install
```
Для того, чтобы запустить интеграционные тесты нужно скопировать файл tests/integration/MerchantSettingsSample.php удалив 
из названия Sample и вставив настройки магазина. Так же в папку tests/integration/merchant_data необходимо положить приватный
ключ. После выполнить команду из корня проекта
```
vendor/bin/phpunit tests/integration
```

## Примеры использования

### 1. Создание чека

<pre><code>
    $client = new Platron\Shtrihm\clients\PostClient('secretKeyData');
        
    $receiptPosition = new Platron\Shtrihm\data_objects\ReceiptPosition('test product', 100.00, 2, Platron\Shtrihm\data_objects\ReceiptPosition::TAX_VAT10);

    $createDocumentService = (new Platron\Shtrihm\services\CreateDocumentRequest($transactionId))
        ->addCustomerEmail('test@test.ru')
        ->addCustomerPhone('79268752662')
        ->addGroupCode('groupCode')
        ->addInn('inn')
        ->addOperationType(Platron\Shtrihm\services\CreateDocumentRequest::OPERATION_TYPE_BUY)
        ->addPaymentType(Platron\Shtrihm\services\CreateDocumentRequest::PAYMENT_TYPE_ELECTRON)
        ->addTaxatitionSystem(Platron\Shtrihm\services\CreateDocumentRequest::TAXATITION_SYSTEM_ESN)
        ->addReceiptPosition($receiptPosition);
    $createDocumentResponse = new Platron\Shtrihm\services\CreateDocumentResponse($client->sendRequest($createDocumentService));
</pre></code>

### 2. Запрос статуса 

<pre><code>
    $client = new Platron\Shtrihm\clients\PostClient('secretKeyData');
    $getStatusServise = new Platron\Shtrihm\services\GetStatusRequest('transactionId');
    $getStatusResponse = new Platron\Shtrihm\services\GetStatusResponse($client->sendRequest($getStatusServise));
</pre></code>