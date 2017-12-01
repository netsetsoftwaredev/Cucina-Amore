<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Observer\Adminhtml;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderCreditmemoRefundObserver implements ObserverInterface
{
    protected $giftcardsCollection;
    protected $giftcardOrdersCollection;
    protected $giftCardsFactory;
    protected $giftCardsOrderFactory;

    public function __construct(
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftcardsCollection,
        \MageWorx\GiftCards\Model\ResourceModel\Order\CollectionFactory $giftcardOrdersCollection,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Model\OrderFactory $giftCardsOrderFactory
    ) {
        $this->giftcardsCollection = $giftcardsCollection;
        $this->giftcardOrdersCollection = $giftcardOrdersCollection;
        $this->giftCardsFactory = $giftCardsFactory;
        $this->giftCardsOrderFactory = $giftCardsOrderFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $creditMemo          = $observer->getCreditmemo();
        
        $order               = $creditMemo->getOrder();

        $giftcardModel       = $this->giftCardsFactory->create();
        $giftcardOrderModel  = $this->giftCardsOrderFactory->create();

        $giftcardOrders      = $this->giftcardOrdersCollection->create()
                                       ->addFieldToFilter('order_id', $order->getId())
                                       ->load();

        foreach ($giftcardOrders as $giftcardOrder) {
            $discount   = $giftcardOrder->getDiscounted();
            $giftcardId = $giftcardOrder->getGiftcardId();
            $giftcardModel->load($giftcardId);
            $giftcardModel->setCardBalance($giftcardModel->getCardBalance() + $discount);
            $giftcardModel->setCardStatus(\MageWorx\GiftCards\Model\GiftCards::STATUS_ACTIVE);
            $giftcardModel->save();
            
            $giftcardOrderModel->setGiftcardId($giftcardId);
            $giftcardOrderModel->setOrderId($order->getId());
            $giftcardOrderModel->setDiscounted(-$discount);
            $giftcardOrderModel->setId(null);
            $giftcardOrderModel->save();
        }
        
        return $this;
    }
}
