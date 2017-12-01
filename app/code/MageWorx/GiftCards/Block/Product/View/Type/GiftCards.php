<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Block\Product\View\Type;

/**
 * Giftcards product data view
 */
class GiftCards extends \Magento\Catalog\Block\Product\View\AbstractView
{
    const PRICE_TYPE_CUSTOMER = 1;
    const PRICE_TYPE_SELECTED = 2;

    /**
     * @var int
     */
    public $priceStatus;

    /**
     * @var int
     */
    public $cardType;

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $currency;
    
    /** 
     * @var array 
     */
    protected $aAdditionalPrices;

    /** 
     * @var \MageWorx\GiftCards\Helper\Data 
     */
    protected $helper;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param \Magento\Directory\Model\Currency $currency
     * @param \MageWorx\GiftCards\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Magento\Directory\Model\Currency $currency,
        \MageWorx\GiftCards\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $arrayUtils, $data);
        $this->_isScopePrivate = true;
        $this->currency = $currency;
        $this->helper = $helper;
    }

    /**
     * Set cardType and priceStatus
     *
     */
    public function _construct()
    {
        $product = $this->getProduct();

        $this->cardType = $product->getData('mageworx_gc_type');

        if ($product->getData('price') == 0) {
            $this->initPriceStatus();
        }
        parent::_construct();
    }

    /**
     * init PriceStatus and additional prices
     */
    protected function initPriceStatus()
    {
        if ($this->getProduct()->getData('mageworx_gc_additional_price')) {
            $this->priceStatus = self::PRICE_TYPE_SELECTED;
            $this->aAdditionalPrices = explode(';', $this->getProduct()->getData('mageworx_gc_additional_price'));
        } else {
            $this->priceStatus = self::PRICE_TYPE_CUSTOMER;
        }
    }

    /**
     * @return int
     */
    public function getPriceStatus()
    {
        return $this->priceStatus;
    }

    /**
     * @return int
     */
    public function getCardType()
    {
        return $this->cardType;
    }
    
    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    
    /**
     * @return bool
     */
    public function isShowMailDeliveryDate()
    {
        return $this->helper->getShowMailDeliveryDate();
    }
    
    /**
     * @return float
     */
    public function getFromAmount()
    {
        return $this->helper->getMinCardValue();
    }

    /**
     * @return float
     */
    public function getToAmount()
    {
        return $this->helper->getMaxCardValue();
    }
    
    /**
     * @return array
     */
    public function getAdditionalPrices()
    {
        return $this->aAdditionalPrices;
    }
}
