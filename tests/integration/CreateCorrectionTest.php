<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\handbooks\CorrectionOperationTypes;
use Platron\Shtrihm\handbooks\CorrectionType;
use Platron\Shtrihm\handbooks\TaxationSystem;
use Platron\Shtrihm\services\CreateCorrectionRequest;
use Platron\Shtrihm\services\CreateCorrectionResponse;
use Platron\Shtrihm\clients\PostClient;
use Platron\Shtrihm\services\GetCorrectionStatusRequest;
use Platron\Shtrihm\services\GetCorrectionStatusResponse;
use Platron\Shtrihm\services\GetReceiptStatusRequest;

class CreateCorrectionTest extends IntegrationTestBase
{
	public function testCreateCorrection(){
		$transactionId = time();
		$createCorrectionRequest = $this->createCorrectionRequest($transactionId);
		$client = new PostClient($this->secretKeyPath, $this->keyPassword, $this->certPath, $this->signedKeyPath);
		$client->setLogger(new TestLogger());
		$responseCreate = $client->sendRequest($createCorrectionRequest);
		$createCorrectionResponse = new CreateCorrectionResponse($client->getLastHttpCode(), $responseCreate);

		$this->assertTrue($createCorrectionResponse->isValid());

		$getStatusRequest = $this->createGetCorrectionStatusRequest($transactionId);
		$responseGetStatus = $client->sendRequest($getStatusRequest);
		$getStatusResponse = new GetCorrectionStatusResponse($client->getLastHttpCode(), $responseGetStatus);

		$this->assertTrue($getStatusResponse->isValid());
	}

	/**
	 * @param $transactionId
	 * @return CreateCorrectionRequest
	 */
	private function createCorrectionRequest($transactionId)
	{
		$createCorrectionRequest = new CreateCorrectionRequest($transactionId);
		$createCorrectionRequest->setDemoMode();
		$createCorrectionRequest->addInn($this->inn);
		$createCorrectionRequest->addGroup($this->groupCode);
		$createCorrectionRequest->addCashSum(100);
		$createCorrectionRequest->addCauseDocumentNumber('Test document number');
		$createCorrectionRequest->addCauseDocumentDate(new \DateTime());
		$createCorrectionRequest->addCorrectionType(new CorrectionType(CorrectionType::BY_PRESCRIPTION));
		$createCorrectionRequest->addType(new CorrectionOperationTypes(CorrectionOperationTypes::BUY));
		$createCorrectionRequest->addDescription('Test description');
		$createCorrectionRequest->addECashSum(10);
		$createCorrectionRequest->addOtherPaymentTypeSum(20);
		$createCorrectionRequest->addPostPaymentSum(30);
		$createCorrectionRequest->addPrepaymentSum(40);
		$createCorrectionRequest->addTax1Sum(1);
		$createCorrectionRequest->addTax2Sum(2);
		$createCorrectionRequest->addTax3Sum(3);
		$createCorrectionRequest->addTax4Sum(4);
		$createCorrectionRequest->addTax5Sum(5);
		$createCorrectionRequest->addTax6Sum(6);
		$createCorrectionRequest->addTaxationSystem(new TaxationSystem(TaxationSystem::ESN));
		$createCorrectionRequest->addTotalSum(200);
		return $createCorrectionRequest;
	}

	/**
	 * @param $transactionId
	 * @return GetCorrectionStatusRequest
	 */
	private function createGetCorrectionStatusRequest($transactionId)
	{
		$getReceiptStatusRequest = new GetCorrectionStatusRequest($this->inn, $transactionId);
		$getReceiptStatusRequest->setDemoMode();
		return $getReceiptStatusRequest;
	}
}