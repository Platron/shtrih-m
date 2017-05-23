<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\SdkException;

/**
 * Все парараметры обязательны для заполнения. Контактные данные требуются - либо email, либо телефон
 */
class CreateDocumentRequest extends BaseServiceRequest{
    
    /** @var string идентификатор группы ККТ */
    protected $groupCode;
    /** @var string тип операции */
    protected $operationType;
    /** @var string */
    protected $id;
    /** @var string */
    protected $customerEmail;
    /** @var int */
    protected $customerPhone;
    /** @var int */
    protected $inn;
    /** @var int */
    protected $paymentType;
    /** @var ReceiptPosition[] Позиции в чеке */
    protected $receiptPositions;
    /** @var string */
    protected $taxatitionSystem;
    
    const 
        OPERATION_TYPE_SELL = 1, // Приход
        OPERATION_TYPE_SELL_REFUND = 2, // Возврат прихода
        OPERATION_TYPE_BUY = 3, // Расход
        OPERATION_TYPE_BUY_REFUND = 4; // Возврат расхода
    
    const 
        PAYMENT_TYPE_CASH = 0,
        PAYMENT_TYPE_ELECTRON = 1,
        PAYMNET_TYPE_PRE_PAID = 2,
        PAYMNET_TYPE_CREDIT = 3,
        PAYMNET_TYPE_OTHER = 4;
    
    const 
        TAXATITION_SYSTEM_OSN = 0, // общая СН
        TAXATITION_SYSTEM_USN_INCOME = 1, // упрощенная СН (доходы)
        TAXATITION_SYSTEM_USN_INCOME_OUTCOME = 2, // упрощенная СН (доходы минус расходы)
        TAXATITION_SYSTEM_ENDV = 3, // единый налог на вмененный доход
        TAXATITION_SYSTEM_ESN = 4, // единый сельскохозяйственный налог
        TAXATITION_SYSTEM_PATENT = 5; // патентная СН
    
    /**
     * @inheritdoc
     */
    public function getRequestUrl() {
        return self::REQUEST_URL;
    }
        
    /**
     * Установить email покупателя
     * @param string $email
     * @return CreateDocumentRequest
     */
    public function addCustomerEmail($email){
        $this->customerEmail = $email;
        return $this;
    }
    
    /**
     * Установить телефон покупателя
     * @param int $phone
     * @return CreateDocumentRequest
     */
    public function addCustomerPhone($phone){
        $this->customerPhone = $phone;
        return $this;
    }
    
    /**
     * Установить inn
     * @param type $inn
     * @return CreateDocumentRequest
     */
    public function addInn($inn){
        $this->inn = $inn;
        return $this;
    }
    
    /**
     * Установить тип платежа. Из констант
     * @param int $paymentType
     * throws SdkException
     * @return CreateDocumentRequest
     */
    public function addPaymentType($paymentType){
        if(!in_array($paymentType, $this->getPaymentTypes())){
            throw new SdkException('Wrong payment type');
        }
        
        $this->paymentType = $paymentType;
        return $this;
    }
    
    /**
     * Добавить позицию в чек
     * @param ReceiptPosition $position
     * @return CreateDocumentRequest
     */
    public function addReceiptPosition(ReceiptPosition $position){
        $this->receiptPositions[] = $position;
        return $this;
    }
    
    /**
     * Добавить SNO. Из констант
     * @param string $taxatitionSystem
     * @throws SdkException
     * @return CreateDocumentRequest
     */
    public function addTaxatitionSystem($taxatitionSystem){
        if(!in_array($taxatitionSystem, $this->getSnoTypes())){
            throw new SdkException('Wrong sno type');
        }
        
        $this->taxatitionSystem = $taxatitionSystem;
        return $this;
    }

    /**
     * @param int $id Идентификатор заказа
     * @return CreateDocumentRequest
     */
    public function __construct($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Добавить тип операции
     * @param string $operationType Тип операции. Из констант
     * @throws SdkException
     * @return CreateDocumentRequest
     */
    public function addOperationType($operationType){
        if(!in_array($operationType, $this->getOperationTypes())){
            throw new SdkException('Wrong operation type');
        }
        
        $this->operationType = $operationType;
        return $this;
    }
    
    /**
     * Добавить код группы
     * @param string $groupCode Идентификатор группы ККТ
     * @return CreateDocumentRequest
     */
    public function addGroupCode($groupCode){
        $this->groupCode = $groupCode;
        return $this;
    }
    
    public function getParameters() {
        $params = [
            'Id' => $this->id,
            'INN' => $this->inn,
            'Content' => [
                'Type' => $this->operationType,
                'Positions' => [],
                'CheckClose' => [
                    'Type' => $this->paymentType,
                ],
                'TaxationSystem' => $this->taxatitionSystem,
            ],
            'CustomerContact' => ($this->customerEmail) ? $this->customerEmail : $this->customerPhone,
        ];
        
        $params = [
            'timestamp' => date('d.m.Y H:i:s'),
            'service' => [
                'inn' => $this->inn,
                'callback_url' => '',
                'payment_address' => $this->paymentAddress,
            ],
            'attributes' => [
                'email' => $this->customerEmail,
                'phone' => $this->customerPhone,
            ],
            'external_id' => $this->externalId,
        ];
        
        $totalAmount = 0;
        foreach($this->receiptPositions as $receiptPosition){
            $totalAmount += $receiptPosition->getPositionSum();
            $params['items'][] = $receiptPosition->getParameters();
        }
        
        $params['total'] = $totalAmount;
        $params['payments'] = [
            'sum' => $totalAmount,
            'type' => $this->paymentType,
        ];
        
        return $params;
    }
    
    protected function getOperationTypes(){
        return [
            self::OPERATION_TYPE_BUY,
            self::OPERATION_TYPE_BUY_REFUND,
            self::OPERATION_TYPE_SELL,
            self::OPERATION_TYPE_SELL_REFUND,
        ];
    }
    
    protected function getPaymentTypes(){
        return [
            self::PAYMENT_TYPE_CASH,
            self::PAYMENT_TYPE_ELECTRON,
            self::PAYMNET_TYPE_CREDIT,
            self::PAYMNET_TYPE_OTHER,
            self::PAYMNET_TYPE_PRE_PAID,
        ];
    }
    
    protected function getSnoTypes(){
        return [
            self::TAXATITION_SYSTEM_ENDV,
            self::TAXATITION_SYSTEM_ESN,
            self::TAXATITION_SYSTEM_OSN,
            self::TAXATITION_SYSTEM_PATENT,
            self::TAXATITION_SYSTEM_USN_INCOME,
            self::TAXATITION_SYSTEM_USN_INCOME_OUTCOME,
        ];
    }
}
