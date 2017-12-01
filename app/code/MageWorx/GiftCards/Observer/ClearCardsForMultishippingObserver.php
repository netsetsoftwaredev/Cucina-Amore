<?php
/**
 * Copyright © 2017 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Observer;

use Magento\Framework\Event\ObserverInterface;

class ClearCardsForMultishippingObserver implements ObserverInterface
{
    /**
     * @var \MageWorx\GiftCards\Model\Session
     */
    protected $giftCardSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Multishipping\Model\Checkout\Type\Multishipping
     */
    protected $checkout;

    /**
     * ClearCardsForMultishipping constructor.
     * @param \MageWorx\GiftCards\Model\Session $giftCardSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        \MageWorx\GiftCards\Model\Session $giftCardSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Multishipping\Model\Checkout\Type\Multishipping $checkout
    ) {
        $this->giftCardSession = $giftCardSession;
        $this->quoteRepository = $quoteRepository;
        $this->checkout = $checkout;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->giftCardSession;
        $cardIds = $this->giftCardSession->getGiftCardsIds();

        if ($cardIds || $this->giftCardSession->getActive()) {
            $this->giftCardSession->clearStorage();
            $this->giftCardSession->setIsReadyToClean(1);
            $this->giftCardSession->setGiftCardBalance(0);
            $this->giftCardSession->setGiftCardsIds([]);
            $cartQuote = $this->checkout->getQuote();
            $cartQuote->collectTotals();
            $this->quoteRepository->save($cartQuote);
        }
        return $this;
    }
}