<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\clients\PostClient;
use Platron\Shtrihm\data_objects\AdditionalUserAttribute;
use Platron\Shtrihm\data_objects\Agent;
use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\data_objects\Settlement;
use Platron\Shtrihm\data_objects\Supplier;
use Platron\Shtrihm\handbooks\AgentTypes;
use Platron\Shtrihm\handbooks\FFDVersion;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\PaymentMethodType;
use Platron\Shtrihm\handbooks\PaymentSubjectType;
use Platron\Shtrihm\handbooks\PaymentType;
use Platron\Shtrihm\handbooks\TaxationSystem;
use Platron\Shtrihm\handbooks\Vates;
use Platron\Shtrihm\services\CreateReceiptRequest;
use Platron\Shtrihm\services\CreateReceiptResponse;
use Platron\Shtrihm\services\GetReceiptStatusRequest;
use Platron\Shtrihm\services\GetReceiptStatusResponse;

class CreateReceiptTest extends IntegrationTestBase
{
	public function testCreateReceipt()
	{
		$transactionId = time();
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
	 * @param $agent
	 * @param $supplier
	 * @return ReceiptPosition
	 */
	private function createReceiptPosition($agent, $supplier)
	{
		$receiptPosition = new ReceiptPosition('test product', 100.00, 2, new Vates(Vates::VAT10));
		$receiptPosition->addAdditionalAttribute('Test');
		$receiptPosition->addAgent($agent);
		$receiptPosition->addCustomsDeclarationNumber('Test custom declaration');
		$receiptPosition->addExcise(100.00);
		$receiptPosition->addManufacturerCountryCode(643);
		$receiptPosition->addNomenclatureCode(null);
		$receiptPosition->addPaymentMethodType(new PaymentMethodType(PaymentMethodType::FULL_PAYMENT));
		$receiptPosition->addPaymentSubjectType(new PaymentSubjectType(PaymentSubjectType::PRODUCT));
		$receiptPosition->addSupplier($supplier);
		$receiptPosition->addUnitOfMeasurement('pounds');
		return $receiptPosition;
	}

	/**
	 * @param $ffdVersion
	 * @return Customer
	 */
	private function createCustomer($ffdVersion)
	{
		$customer = new Customer($ffdVersion);
		$customer->addInn('7707083893');
		$customer->addName('Name Surname');
		return $customer;
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
		$receiptPosition = $this->createReceiptPosition($agent, $supplier);
		$customer = $this->createCustomer(FFDVersion::V1_05);
		$payment = $this->createPayment();
		$settlement = $this->createSettlement();

		$createReceiptRequest = new CreateReceiptRequest($transactionId, FFDVersion::V1_05);
		$createReceiptRequest->setDemoMode();
		$createReceiptRequest->addAdditionalAttribute('Test');
		$createReceiptRequest->addAdditionalUserAttribute(new AdditionalUserAttribute('Additional name', 'Additional value'));
		$createReceiptRequest->addPhone('79150000004');
		$createReceiptRequest->addEmail('test@test.ru');
		$createReceiptRequest->addCustomer($customer);
		$createReceiptRequest->addInn($this->inn);
		$createReceiptRequest->addGroup($this->groupCode);
		$createReceiptRequest->addKey($this->inn);
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
