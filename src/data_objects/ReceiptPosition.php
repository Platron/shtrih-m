<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\SdkException;

class ReceiptPosition extends BaseDataObject{
    
    const 
        TAX_NONE = 6,
        TAX_VAT0 = 5,
        TAX_VAT10 = 2,
        TAX_VAT18 = 1,
        TAX_VAT110 = 4,
        TAX_VAT118 = 3;
    
    /** @var string */
    protected $tax;
    /** @var string */
    protected $text;
    /** @var float */
    protected $price;
    /** @var int */
    protected $quantity;
    
    /**
     * @param type $name Описание товара
     * @param type $price Цена товаров с учетом скидок
     * @param type $quantity Количество товара
     * @param type $vat Налоговая ставка из констант
     * @throws SdkException
     */
    public function __construct($name, $price, $quantity, $vat) {
        if(!in_array($vat, $this->getVates())){
            throw new SdkException('Wrong vat');
        }
        
        $this->text = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->tax = $vat;
    }
    
    /**
     * Получить сумму позиции
     * @return float
     */
    public function getPositionSum(){
        return $this->price;
    }
    
    /**
     * Получить все возможные налоговые ставки
     */
    protected function getVates(){
        return [
            self::TAX_NONE,
            self::TAX_VAT0,
            self::TAX_VAT10,
            self::TAX_VAT110,
            self::TAX_VAT118,
            self::TAX_VAT18,
        ];
    }
}
