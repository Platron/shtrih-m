<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\TaxatitionSystem;

/**
 * Все парараметры обязательны для заполнения. Контактные данные требуются - либо email, либо телефон
 */
class CreateDocumentRequest extends BaseServiceRequest{
    
    /** @var string идентификатор группы ККТ */
    protected $group;
    /** @var string тип операции */
    protected $operationType;
    /** @var string */
    protected $id;
	/** @var Customer */
	protected $customer;
    /** @var int */
    protected $inn;
    /** @var ReceiptPosition[] Позиции в чеке */
    protected $receiptPositions;
	/** @var Payment[] Оплаты */
	protected $payments;
    /** @var string */
    protected $taxatitionSystem;
    /** @var integer */
    protected $key;
	/** @var string */
    protected $additionalAttribute;

	/**
	 * @param int $id Идентификатор заказа
	 * @return CreateDocumentRequest
	 */
	public function __construct($id) {
		$this->id = $id;
		return $this;
	}

    /**
     * @inheritdoc
     */
    public function getRequestUrl() {
        return $this->getBaseUrl();
    }

	/**
	 * @param Customer $customer
	 * @return $this
	 */
    public function addCustomer(Customer $customer){
		$this->customer = $customer;
		return $this;
	}

    /**
     * @param type $inn
     * @return CreateDocumentRequest
     */
    public function addInn($inn){
        $this->inn = $inn;
        return $this;
    }

    /**
     * @param ReceiptPosition $position
     * @return CreateDocumentRequest
     */
    public function addReceiptPosition(ReceiptPosition $position){
        $this->receiptPositions[] = $position;
        return $this;
    }

	/**
	 * @param Payment $payment
	 * @return $this
	 */
    public function addPayment(Payment $payment){
		$this->payments[] = $payment;
		return $this;
	}
    
    /**
     * @param TaxatitionSystem $taxatitionSystem
     * @return CreateDocumentRequest
     */
    public function addTaxatitionSystem(TaxatitionSystem $taxatitionSystem){
        $this->taxatitionSystem = $taxatitionSystem->getValue();
        return $this;
    }
    
    /**
     * @param OperationType $operationType Тип операции. Из констант
     * @return CreateDocumentRequest
     */
    public function addOperationType(OperationType $operationType){
        $this->operationType = $operationType;
        return $this;
    }

	/**
	 * @param $additionalAttribute
	 * @return $this
	 */
    public function addAdditionalAttribute($additionalAttribute){
    	$this->additionalAttribute = $additionalAttribute;
    	return $this;
	}
    
    /**
     * @param string $group Идентификатор группы ККТ
     * @return CreateDocumentRequest
     */
    public function addGroup($group){
        $this->group = $group;
        return $this;
    }
    
    /**
     * @param integer $key
     * @return CreateDocumentRequest
     */
    public function addKey($key){
        $this->key = $key;
        return $this;
    }
    
    public function getParameters() {
    	$items = [];
        foreach($this->receiptPositions as $receiptPosition){
        	$items[] = $receiptPosition->getParameters();
        }
        $payments = [];
        foreach($this->payments as $payment){
			$payments[] = $payment->getParameters();
		}

        $params = [
            'Id' => $this->id,
            'INN' => $this->inn,
            'key' => $this->key,
            'Group' => $this->group,
			'additionalAttribute' => $this->additionalAttribute,
            'Content' => [
                'Type' => $this->operationType,
                'Positions' => $items,
                'CheckClose' => [
                    'Payments' => $payments,
                    'TaxationSystem' => $this->taxatitionSystem,
                ],
            ],
        ];

        if($this->customer) {
			$params += $this->customer->getParameters();
		}

		if($this->settlement){
			$params += $this->settlement->getParameters();
		}
        
        return $params;
    }
}
