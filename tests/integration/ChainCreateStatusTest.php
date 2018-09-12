<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\clients\PostClient;
use Platron\Shtrihm\data_objects\AdditionalAttribute;
use Platron\Shtrihm\data_objects\Agent;
use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\data_objects\Supplier;
use Platron\Shtrihm\handbooks\AgentTypes;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\PaymentMethodType;
use Platron\Shtrihm\handbooks\PaymentSubjectType;
use Platron\Shtrihm\handbooks\PaymentType;
use Platron\Shtrihm\handbooks\TaxatitionSystem;
use Platron\Shtrihm\handbooks\Vates;
use Platron\Shtrihm\services\CreateDocumentRequest;
use Platron\Shtrihm\services\CreateDocumentResponse;
use Platron\Shtrihm\services\GetStatusRequest;
use Platron\Shtrihm\services\GetStatusResponse;

class ChainCreateStatusTest extends IntegrationTestBase {
    public function testChainCreateStatus(){
    	$agent = new Agent(new AgentTypes(AgentTypes::BANK_PAYMENT_AGENT));
		$agent->addPaymentAgentOperation('Test');
		$agent->addPaymentAgentPhoneNumber('79150000001');
		$agent->addPaymentOperatorAddress('Test address');
		$agent->addPaymentOperatorINN('1234567890');
		$agent->addPaymentOperatorName('Test agent');
		$agent->addPaymentTransferOperatorPhoneNumber('79150000002');

		$supplier = new Supplier('0987654321', 'Test supplier');
		$supplier->addPhone('79150000003');

        $receiptPosition = new ReceiptPosition('test product', 100.00, 2, new Vates(Vates::TAX_VAT10));
		$receiptPosition->addAdditionalAttribute('Test');
		$receiptPosition->addAgent($agent);
		$receiptPosition->addCustomsDeclarationNumber('Test custom declaration');
		$receiptPosition->addExcise('Test excise');
		$receiptPosition->addManufacturerCountryCode('Test manufacture code');
		$receiptPosition->addNomenclatureCode('Test nomenclature code');
		$receiptPosition->addPaymentMethodType(new PaymentMethodType(PaymentMethodType::FULL_PAYMENT));
		$receiptPosition->addPaymentSubjectType(new PaymentSubjectType(PaymentSubjectType::PRODUCT));
		$receiptPosition->addSupplier($supplier);
		$receiptPosition->addUnitOfMeasurement('Test unit of measuring');

		$customer = new Customer();
		$customer->addPhone('79150000004');
		$customer->addEmail('test@test.ru');
		$customer->addInn('1234512345');
		$customer->addName('Name Surname');
		$customer->addAdditionalAttribute(new AdditionalAttribute('Additional name', 'Additional value'));

		$payment = new Payment(new PaymentType(PaymentType::PAYMNET_TYPE_MASTERCARD), 200.00);

		$transactionId = time();
        $createDocumentService = new CreateDocumentRequest($transactionId);
		$createDocumentService->addAdditionalAttribute('Test additional attribute');
		$createDocumentService->addCustomer($customer);
		$createDocumentService->addInn($this->inn);
		$createDocumentService->addGroup($this->groupCode);
		$createDocumentService->addKey('Test Key');
		$createDocumentService->addOperationType(new OperationType(OperationType::OPERATION_TYPE_BUY));
		$createDocumentService->addPayment($payment);
		$createDocumentService->addReceiptPosition($receiptPosition);
		$createDocumentService->addTaxatitionSystem(new TaxatitionSystem(TaxatitionSystem::TAXATITION_SYSTEM_ENDV));

		$client = new PostClient($this->secretKeyPath, $this->keyPassword, $this->certPath, $this->signedKeyPath);
        $responseCreate = $client->sendRequest($createDocumentService);
        $createDocumentResponse = new CreateDocumentResponse($client->getLastHttpCode(), $responseCreate);
        
        $this->assertTrue($createDocumentResponse->isValid());
        
        $getStatusService = new GetStatusRequest($this->inn, $transactionId);
        $responseGetStatus = $client->sendRequest($getStatusService);
        $getStatusResponse = new GetStatusResponse($client->getLastHttpCode(), $responseGetStatus);

        $this->assertTrue($getStatusResponse->isValid());
    }
}
