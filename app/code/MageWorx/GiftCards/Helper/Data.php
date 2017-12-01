<?php
/**
 * Copyright © 2017 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Helper;

/**
 * MageWorx data helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**#@+
     * XML paths for config settings
     */
    const XML_SHOW_IN_CART = 'mageworx_giftcards/main/show_in_shopping_cart';
    const XML_CARD_ACTIVATION_ORDER_STATUSES = 'mageworx_giftcards/main/orderstatus';
    const XML_ORDER_STATUSES = 'mageworx_giftcards/email/orderstatus';
    const XML_ADD_CODE_TO_PRODUCT = 'mageworx_giftcards/main/add_code_to_product';
    const XML_MIN_CARD_VALUE = 'mageworx_giftcards/main/min_card_value';
    const XML_MAX_CARD_VALUE = 'mageworx_giftcards/main/max_card_value';
    const XML_SHOW_MAIL_DELIVERY_DATE = 'mageworx_giftcards/main/show_mail_delivery_date';
    const XML_SUPPORT_MAIL = 'trans_email/ident_general/email';
    const XML_DISABLE_MULTISHIPPING = 'mageworx_giftcards/main/disable_multishipping';

    /**
     * @var \Magento\Store\Model\Information
     */
    protected $storeInformation;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Store\Model\Information $storeInformation
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\Information $storeInformation
    ) {
    
        $this->storeInformation = $storeInformation->getStoreInformationObject($storeManager->getStore());
        parent::__construct($context);
    }

    public function showInCart()
    {
        return (bool) $this->scopeConfig->getValue(self::XML_SHOW_IN_CART, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getStoreName()
    {
        return $this->storeInformation['name'];
    }
    
    public function getSupportMail()
    {
        return $this->scopeConfig->getValue(self::XML_SUPPORT_MAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getOrderStatuses()
    {
        return $this->scopeConfig->getValue(self::XML_ORDER_STATUSES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Retrieve comma-separated order statuses
     *
     * @return string|null
     */
    public function getCardActivationOrderStatuses()
    {
        return $this->scopeConfig->getValue(
            self::XML_CARD_ACTIVATION_ORDER_STATUSES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getAddCodeToProduct()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_ADD_CODE_TO_PRODUCT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getStorePhone()
    {
        return $this->storeInformation['phone'];
    }
    
    public function getMinCardValue()
    {
        return $this->scopeConfig->getValue(self::XML_MIN_CARD_VALUE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getMaxCardValue()
    {
        return $this->scopeConfig->getValue(self::XML_MAX_CARD_VALUE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getShowMailDeliveryDate()
    {
        return (bool) $this->scopeConfig->getValue(self::XML_SHOW_MAIL_DELIVERY_DATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getIsDisableMultishipping()
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_DISABLE_MULTISHIPPING,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
