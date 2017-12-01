<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Cart;

class ActivateGiftCard extends \Magento\Checkout\Controller\Cart
{
    /**
     * Sales quote repository
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * Coupon factory
     *
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $couponFactory;
    
    /**
     * Gift Cards session
     *
     * @var \MageWorx\GiftCards\Model\SessionFactory
     */
    protected $giftCardSession;

    /**
     *   @var \Magento\Framework\Escaper
     */
    
    protected $escaper;
    
    /**
     * Gift Cards Factory
     *
     * var@ \MageWorx\GiftCards\GiftCardsRepository
     */
    protected $giftCardsRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \MageWorx\GiftCards\Model\Session $giftCardSession
     * @param \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
     * @param \Magento\Framework\Escaper $escaper
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
        \MageWorx\GiftCards\Model\Session $giftCardSession,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository,
        \Magento\Framework\Escaper $escaper
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
        $this->giftCardsRepository = $giftCardsRepository;
        $this->escaper = $escaper;
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
        $giftCardCode = trim((string)$this->getRequest()->getParam('giftcard_code'));

        try {
            $card = $this->giftCardsRepository->getByCode($giftCardCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(
                __('Gift Card "%1" is not valid.', $this->escaper->escapeHtml($giftCardCode))
            );
            return $this->_goBack();
        }

        $cartQuote = $this->cart->getQuote();

        if ($card->getId() && ($card->getCardStatus() == \MageWorx\GiftCards\Model\GiftCards::STATUS_ACTIVE)) {
            $card->activateCard();

            $this->messageManager->addSuccessMessage(
                __('Gift Card "%1" was applied.', $this->escaper->escapeHtml($giftCardCode))
            );
            $this->giftCardSession->setActive(1);
            $this->_setSessionVars($card);
            $cartQuote->getShippingAddress()->setCollectShippingRates(true);
            $cartQuote->collectTotals();
            $this->quoteRepository->save($cartQuote);
        } else {
            if ($card->getId() && ($card->getCardStatus() == \MageWorx\GiftCards\Model\GiftCards::STATUS_USED)) {
                $this->messageManager->addErrorMessage(
                    __('Gift Card "%1" was used.', $this->escaper->escapeHtml($giftCardCode))
                );
            } else {
                $this->messageManager->addErrorMessage(
                    __('Gift Card "%1" is not valid.', $this->escaper->escapeHtml($giftCardCode))
                );
            }
        }

        return $this->_goBack();
    }

    protected function _setSessionVars($card)
    {
        $giftCardsIds = $this->giftCardSession->getGiftCardsIds();

        if (!empty($giftCardsIds)) {
            if (!array_key_exists($card->getId(), $giftCardsIds)) {
                $giftCardsIds[$card->getId()] =  ['balance' => $card->getCardBalance(), 'code' => $card->getCardCode()];
                $this->giftCardSession->setGiftCardsIds($giftCardsIds);

                $newBalance = $this->giftCardSession->getGiftCardBalance() + $card->getCardBalance();
                $this->giftCardSession->setGiftCardBalance($newBalance);
            }
        } else {
            $giftCardsIds[$card->getId()] = ['balance' => $card->getCardBalance(), 'code' => $card->getCardCode()];
            $this->giftCardSession->setGiftCardsIds($giftCardsIds);

            $this->giftCardSession->setGiftCardBalance($card->getCardBalance());
        }
    }
}
