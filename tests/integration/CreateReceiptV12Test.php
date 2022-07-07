<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\clients\PostClient;
use Platron\Shtrihm\data_objects\AdditionalUserAttribute;
use Platron\Shtrihm\data_objects\Agent;
use Platron\Shtrihm\data_objects\Barcode;
use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\OperationalAttribute;
use Platron\Shtrihm\data_objects\IndustryAttribute;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\data_objects\Settlement;
use Platron\Shtrihm\data_objects\Supplier;
use Platron\Shtrihm\handbooks\AgentTypes;
use Platron\Shtrihm\handbooks\BarcodeTypes;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\PaymentMethodType;
use Platron\Shtrihm\handbooks\PaymentSubjectType;
use Platron\Shtrihm\handbooks\PaymentType;
use Platron\Shtrihm\handbooks\TaxationSystem;
use Platron\Shtrihm\handbooks\Vates;
use Platron\Shtrihm\handbooks\FFDVersion;
use Platron\Shtrihm\services\CreateReceiptRequest;
use Platron\Shtrihm\services\CreateReceiptResponse;
use Platron\Shtrihm\services\GetReceiptStatusRequest;
use Platron\Shtrihm\services\GetReceiptStatusResponse;

class CreateReceiptV12Test extends IntegrationTestBase
{
	public function __construct()
	{
		parent::__construct();

		$this->groupCode = MerchantSettings::GROUP_CODE . '_2';
	}
	public function testCreateReceipt()
	{
		$transactionId = time() + 100;
		$createReceiptRequest = $this->createReceiptRequest($transactionId);

		$client = new PostClient($this->secretKeyPath, $this->keyPassword, $this->certPath, $this->signedKeyPath);
		$client->setLogger(new TestLogger());
		$responseCreate = $client->sendRequest($createReceiptRequest);
		$createReceiptResponse = new CreateReceiptResponse($client->getLastHttpCode(), $responseCreate);

		$this->assertTrue($createReceiptResponse->isValid());

		$getStatusRequest = $this->createGetReceiptStatusRequest($transactionId);
		$responseGetStatus = $client->sendRequest($getStatusRequest);
		$getStatusResponse = new GetReceiptStatusResponse($client->getLastHttpCode(), $responseGetStatus);

		$this->assertTrue($getStatusResponse->isValid());
	}

	/**
	 * @return Agent
	 */
	private function createAgent()
	{
		$agent = new Agent(new AgentTypes(AgentTypes::BANK_PAYMENT_AGENT));
		$agent->addPaymentAgentOperation('Test');
		$agent->addPaymentAgentPhoneNumber('79150000001');
		$agent->addPaymentAgentPhoneNumber('79150000002');
		$agent->addPaymentOperatorAddress('Test address');
		$agent->addPaymentOperatorINN('1234567890');
		$agent->addPaymentOperatorName('Test agent');
		$agent->addPaymentTransferOperatorPhoneNumber('79150000003');
		$agent->addPaymentTransferOperatorPhoneNumber('79150000004');
		return $agent;
	}

	/**
	 * @return Supplier
	 */
	private function createSupplier()
	{
		$supplier = new Supplier('7707083893', 'Test supplier');
		$supplier->addPhone('79150000005');
		$supplier->addPhone('79150000006');
		return $supplier;
	}

	/**
	 * @return IndustryAttribute
	 */
	private function createPositionIndustryAttribute()
	{
		$industryAttribute = new IndustryAttribute();
		$industryAttribute->addFoivId("012");
		$industryAttribute->addCauseDocumentDate("12.08.2021");
		$industryAttribute->addCauseDocumentNumber("666");
		$industryAttribute->addValue("position industry");
		return $industryAttribute;
	}

	/**
	 * @param $agent
	 * @param $supplier
	 * @param $industryAttribute
	 * @param $barcodes
	 * @return ReceiptPosition
	 */
	private function createReceiptPosition($agent, $supplier, $industryAttribute, $barcodes)
	{
		$receiptPosition = new ReceiptPosition('test product', 100.00, 1, new Vates(Vates::VAT10));
		$receiptPosition->addAdditionalAttribute('Test');
		$receiptPosition->addAgent($agent);
		$receiptPosition->addCustomsDeclarationNumber('Test custom declaration');
		$receiptPosition->addExcise(100.00);
		$receiptPosition->addManufacturerCountryCode(643);
		$receiptPosition->addPaymentMethodType(new PaymentMethodType(PaymentMethodType::FULL_PAYMENT));
		$receiptPosition->addPaymentSubjectType(new PaymentSubjectType(PaymentSubjectType::PRODUCT));
		$receiptPosition->addSupplier($supplier);

		$receiptPosition->addUnitTaxSum(0.23);
		$receiptPosition->addQuantityMeasurementUnit(0);
		$itemCode = "0104605469004307215054732358413";
		$receiptPosition->addItemCode($itemCode);
		$receiptPosition->addPlannedStatus(1);
		$receiptPosition->addIndustryAttribute($industryAttribute);
		$receiptPosition->addBarcodes($barcodes);
		return $receiptPosition;
	}

	/**
	 * @param $ffdVersion
	 * @return Customer
	 */
	private function createCustomer($ffdVersion)
	{
		$customer = new Customer($ffdVersion);
		$customer->addName('Name Surname');
		$customer->addInn('7707083893');
		$customer->addBirthDate('12.03.2021');
		$customer->addCitizenship("643");
		$customer->addIdentityDocumentCode("01");
		$customer->addIdentityDocumentData("multipassport");
		$customer->addAddress("Басеенная 36");
		return $customer;
	}

	/**
	 * @return OperationalAttribute
	 */
	private function createOperationalAttribute()
	{
		$operationalAttribute = new OperationalAttribute(0);
		$operationalAttribute->addDate("2021-08-12T18:36:16");
		$operationalAttribute->addValue("operational");
		return $operationalAttribute;
	}

	/**
	 * @return  IndustryAttribute
	 */
	private function createIndustryAttribute()
	{
		$industryAttribute = new IndustryAttribute();
		$industryAttribute->addFoivId("010");
		$industryAttribute->addCauseDocumentDate("11.08.2021");
		$industryAttribute->addCauseDocumentNumber("999");
		$industryAttribute->addValue("industry");
		return $industryAttribute;
	}

	/**
	 * @return Barcode
	 */
	private function createBarcodes()
	{
		$barcode = new Barcode(new BarcodeTypes(BarcodeTypes::EAN8), "46198532");
		return $barcode;
	}

	/**
	 * @return Payment
	 */
	private function createPayment()
	{
		$payment = new Payment(new PaymentType(PaymentType::CASH), 200.00);
		return $payment;
	}

	/**
	 * @param $transactionId
	 * @return CreateReceiptRequest
	 */
	private function createReceiptRequest($transactionId)
	{
		$agent = $this->createAgent();
		$supplier = $this->createSupplier();
		$barcodes = $this->createBarcodes();
		$positionIndustryAttribute = $this->createPositionIndustryAttribute();

		$receiptPosition = $this->createReceiptPosition($agent, $supplier, $positionIndustryAttribute, $barcodes);
		$customer = $this->createCustomer(FFDVersion::V1_2);
		$operationalAttribute = $this->createOperationalAttribute();
		$industryAttribute = $this->createIndustryAttribute();
		$payment = $this->createPayment();
		$settlement = $this->createSettlement();

		$createReceiptRequest = new CreateReceiptRequest($transactionId, FFDVersion::V1_2);
		$createReceiptRequest->setDemoMode();

		$createReceiptRequest->addAdditionalAttribute('Test');
		$createReceiptRequest->addAdditionalUserAttribute(new AdditionalUserAttribute('Additional name', 'Additional value'));
		$createReceiptRequest->addPhone('79150000004');
		$createReceiptRequest->addEmail('test@test.ru');
		$createReceiptRequest->addCustomer($customer);
		$createReceiptRequest->addOperationalAttribute($operationalAttribute);
		$createReceiptRequest->addIndustryAttribute($industryAttribute);
		$createReceiptRequest->addBarcodes($barcodes);
		$createReceiptRequest->addInn($this->inn);
		$createReceiptRequest->addGroup($this->groupCode);
		$createReceiptRequest->addKey($this->inn);
		$createReceiptRequest->addMeta("some meta");
		$createReceiptRequest->addIgnoreItemCodeCheck(false);
		$createReceiptRequest->addOperationType(new OperationType(OperationType::SELL));
		$createReceiptRequest->addPayment($payment);
		$createReceiptRequest->addReceiptPosition($receiptPosition);
		$createReceiptRequest->addTaxationSystem(new TaxationSystem(TaxationSystem::OSN));
		$createReceiptRequest->addSettlement($settlement);
		return $createReceiptRequest;
	}

	/**
	 * @param $transactionId
	 * @return GetReceiptStatusRequest
	 */
	private function createGetReceiptStatusRequest($transactionId)
	{
		$getReceiptStatusRequest = new GetReceiptStatusRequest($this->inn, $transactionId);
		$getReceiptStatusRequest->setDemoMode();
		return $getReceiptStatusRequest;
	}

	/**
	 * @return Settlement
	 */
	private function createSettlement()
	{
		return new Settlement('Test address', 'Test place');
	}
}
