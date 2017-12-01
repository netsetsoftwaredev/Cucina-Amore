<?php
/**
 * Copyright © 2015 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Cart;

class DeActivateGiftCard extends \Magento\Checkout\Controller\Cart
{
    /**
     * Sales quote repository
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;
    
    /**
     * Gift Cards session
     *
     * @var \MageWorx\GiftCards\Model\Session
     */
    protected $giftCardSession;

    /**
     * Coupon factory
     *
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $couponFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \MageWorx\GiftCards\Model\Session $giftCardSession
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
        $this->couponFactory = $couponFactory;
        $this->quoteRepository = $quoteRepository;
        $this->giftCardSession = $giftCardSession;
    }

    /**
     * Initialize coupon
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $cardId   = trim((string)$this->getRequest()->getParam('id'));
        $oSession = $this->giftCardSession;
        $cardIds  = $oSession->getGiftCardsIds();

        if ($cardIds) {

            $sessionBalance = $oSession->getGiftCardBalance();
            $newSessionBalance = $sessionBalance - $cardIds[$cardId]['balance'];

            unset($cardIds[$cardId]);

            if (empty($cardIds)) {
                $oSession->clearStorage();
                $oSession->setIsReadyToClean(1);
            }

            $oSession->setGiftCardBalance($newSessionBalance);
            $oSession->setGiftCardsIds($cardIds);

            $cartQuote = $this->cart->getQuote();
            $cartQuote->getShippingAddress()->setCollectShippingRates(true);
            $cartQuote->collectTotals();
            $this->quoteRepository->save($cartQuote);
        }

        return $this->_goBack();
    }
}
