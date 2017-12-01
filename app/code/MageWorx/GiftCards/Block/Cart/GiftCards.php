<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Cart;

class GiftCards extends \Magento\Checkout\Block\Cart\AbstractCart
{
    protected $giftcardsSession;
    
    protected $currency;
    
    protected $helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \MageWorx\GiftCards\Helper\Data $helper
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \MageWorx\GiftCards\Model\Session $giftcardsSession,
        \Magento\Directory\Model\Currency $currency,
        \MageWorx\GiftCards\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->_isScopePrivate = true;
        $this->giftcardsSession = $giftcardsSession;
        $this->currency = $currency;
        $this->helper = $helper;
    }
    
    public function getSessionActive()
    {
        return $this->giftcardsSession->getActive();
    }
    
    public function getFrontOptions()
    {
        return $this->giftcardsSession->getFrontOptions();
    }
    
    public function getCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }
    
    public function canShow()
    {
        return $this->helper->showInCart();
    }
}
