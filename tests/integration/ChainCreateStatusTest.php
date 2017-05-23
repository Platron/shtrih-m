<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\clients\PostClient;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\services\CreateDocumentRequest;
use Platron\Shtrihm\services\CreateDocumentResponse;
use Platron\Shtrihm\services\GetStatusRequest;
use Platron\Shtrihm\services\GetStatusResponse;

class ChainCreateStatusTest extends IntegrationTestBase {
    public function testChainCreateStatus(){
        $transactionId = time();
        $client = new PostClient($this->secretKey);
        
        $receiptPosition = new ReceiptPosition('test product', 100.00, 2, ReceiptPosition::TAX_VAT10);
        
        $createDocumentService = (new CreateDocumentRequest($transactionId))
            ->addCustomerEmail('test@test.ru')
            ->addCustomerPhone('79268752662')
            ->addGroupCode($this->groupCode)
            ->addInn($this->inn)
            ->addOperationType(CreateDocumentRequest::OPERATION_TYPE_BUY)
            ->addPaymentType(CreateDocumentRequest::PAYMENT_TYPE_ELECTRON)
            ->addTaxatitionSystem(CreateDocumentRequest::TAXATITION_SYSTEM_ESN)
            ->addReceiptPosition($receiptPosition);
        $createDocumentResponse = new CreateDocumentResponse($client->sendRequest($createDocumentService));
        
        $this->assertTrue($createDocumentResponse->isValid());
        
        $getStatusServise = new GetStatusRequest($transactionId);
        $getStatusResponse = new GetStatusResponse($client->sendRequest($getStatusServise));
        
        $this->assertTrue($getStatusResponse->isValid());
    }
}
