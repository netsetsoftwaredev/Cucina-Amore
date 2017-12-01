<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Model\Quote;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\Http as Request;

class Discount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Discount calculation object
     *
     * @var \Magento\SalesRule\Model\Validator
     */
    protected $calculator;

    /**
     * Core event manager proxy
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    protected $giftcardsSession;
    protected $giftcardsCollection;
    protected $cards;
    protected $giftCardBalance;
    protected $baseGiftCardBalance;
    protected $origGiftCardBalance;
    protected $origBaseGiftCardBalance;
    protected $shippingDiscountAdditional;
    protected $baseShippingDiscountAdditional;
    protected $shippingDiscount;
    protected $baseShippingDiscount;
    protected $logger;
    protected $request;

    /**
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\SalesRule\Model\Validator $validator
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \MageWorx\GiftCards\Model\Session $giftcardsSession,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftcardsCollection,
        Request $request,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->eventManager = $eventManager;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
        $this->giftcardsSession = $giftcardsSession;
        $this->giftcardsCollection = $giftcardsCollection;
        $this->logger = $logger;
        $this->request   = $request;
    }

    /**
     * Collect address discount amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $store = $this->storeManager->getStore($quote->getStoreId());
        $address = $shippingAssignment->getShipping()->getAddress();

        $items = $shippingAssignment->getItems();

        if (!count($items)) {
            return $this;
        }

        $giftcardsIds = $this->giftcardsSession->getGiftCardsIds();
        $quote->setUseGiftCard(false);
        $quote->setMageworxGiftcardsDescription(null);
        $quote->setMageworxGiftcardsAmount(0);
        $quote->setBaseMageworxGiftcardsAmount(0);

        $this->giftCardBalance = 0;
        $this->baseGiftCardBalance = 0;
        $this->origGiftCardBalance = 0;
        $this->origBaseGiftCardBalance = 0;
        $this->shippingDiscountAdditional = 0;
        $this->baseShippingDiscountAdditional = 0;
        $this->shippingDiscount = 0;
        $this->baseShippingDiscount = 0;
        
        $giftCardsDiscount = 0;
        $baseGiftCardsDiscount = 0;
        
        
        $usedCards = [];
        if ($this->giftcardsSession->getActive() && $giftcardsIds) {
        
            $quote_subtotal = $total->getSubtotal();
            $quote_base_subtotal = $total->getBaseSubtotal();
            
            $giftcards_total = 0;

            $quote->setUseGiftCard(true);
            $cards = $this->giftcardsCollection->create()->addFieldToFilter('card_id', ['in' => array_keys($giftcardsIds)])->load();
            foreach ($cards as $card) {
                $this->cards[$card->getId()] = ['balance' => $card->getCardBalance(), 'code' => $card->getCardCode()];
            }

            $frontData = [];
            foreach ($this->cards as $id => $_card) {
                if ($quote_subtotal > 0) {
                    $card_applied = min($quote_subtotal, $_card['balance']);
                    $card_base_applied = min($quote_base_subtotal, $_card['balance']);
                
                    $quote_subtotal -= $card_applied;
                    $quote_base_subtotal -= $card_base_applied;
                    
                    $giftcards_total += $card_applied;
                
                    $frontData[$id]['applied'] = $card_applied;
                    $frontData[$id]['remaining'] = $_card['balance'] - $card_applied;
                    $frontData[$id]['code'] = $_card['code'];
                }
            }
            
            $description = '';
            $descriptionArray = $address->getDiscountDescriptionArray();
            
            if ($descriptionArray === null) {
                $descriptionArray = [];
            }
            
            foreach ($this->cards as $key => $_card) {
                $description .= ' '.$_card['code'];
                $descriptionArray[$key] = $_card['code'];
            }

            $address->setDiscountDescriptionArray($descriptionArray);
            $this->prepareDescription($address);

            $total->addTotalAmount('mageworx_giftcards', -$giftcards_total);
            $total->addBaseTotalAmount('mageworx_giftcards', -$giftcards_total);

            $total->setDiscountDescription($address->getDiscountDescription());

            $total->setSubtotalWithDiscount($total->getSubtotal() - $giftcards_total);
            $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() - $giftcards_total);

            $quote->setMageworxGiftcardsAmount(-$giftcards_total);
            $quote->setBaseMageworxGiftcardsAmount(-$giftcards_total);
            $quote->setMageworxGiftcardsDescription(' Gift Card ('.implode(',', $descriptionArray).')');

            $quote->setSubtotalWithDiscount($total->getSubtotal() - $giftcards_total);
            $quote->setBaseSubtotalWithDiscount($total->getBaseSubtotal() - $giftcards_total);

            $quote->setGiftCardsIds($this->cards);
            $this->giftcardsSession->setFrontOptions($frontData);
            $quote->save();
        }
        return $this;
    }

    /**
     * Add discount total information to address
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array|null
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $result = null;
        $amount = $total->getMageworxGiftcardsAmount();

        if ($amount != 0) {
            $description = $total->getDiscountDescription();
            $result = [
                'code' => 'mageworx_giftcards',
                'title' => strlen($description) ? __('Gift Card (%1)', $description) : __('Gift Card'),
                'value' => $amount,
            ];
        }
        return $result;
    }

    public function prepareDescription($address, $separator = ', ')
    {
        $descriptionArray = $address->getDiscountDescriptionArray();
        if (!$descriptionArray && $address->getQuote()->getItemVirtualQty() > 0) {
            $descriptionArray = $address->getQuote()->getBillingAddress()->getDiscountDescriptionArray();
        }

        $description = $descriptionArray && is_array(
            $descriptionArray
        ) ? implode(
            $separator,
            array_unique($descriptionArray)
        ) : '';

        $address->setDiscountDescription($description);
        return $this;
    }
}
