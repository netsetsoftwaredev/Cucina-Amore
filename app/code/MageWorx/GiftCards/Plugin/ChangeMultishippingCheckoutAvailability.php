<?php
/**
 * Copyright © 2017 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Plugin;

class ChangeMultishippingCheckoutAvailability
{
    /**
     * @var \MageWorx\GiftCards\Helper\Data
     */
    protected $helperData;

    /**
     * @var \MageWorx\GiftCards\Model\Session
     */
    protected $giftCardSession;

    /**
     * ChangeMultishippingCheckoutAvailability constructor.
     * @param \MageWorx\GiftCards\Helper\Data $helperData
     */
    public function __construct(
        \MageWorx\GiftCards\Helper\Data $helperData,
        \MageWorx\GiftCards\Model\Session $giftCardSession

    ) {
        $this->helperData = $helperData;
        $this->giftCardSession = $giftCardSession;
    }

    /**
     * @param \Magento\Catalog\Model\Product $subject
     * @param boolean $result
     */
    public function afterIsMultishippingCheckoutAvailable(\Magento\Multishipping\Helper\Data $subject, $result)
    {
        if ($result && $this->helperData->getIsDisableMultishipping()) {
            if ($this->giftCardSession->getGiftCardsIds()) {
                $result = false;
            }
        }
        return $result;
    }
}