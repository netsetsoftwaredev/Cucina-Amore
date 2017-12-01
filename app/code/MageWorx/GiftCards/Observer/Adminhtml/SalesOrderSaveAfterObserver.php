<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Observer\Adminhtml;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderSaveAfterObserver implements ObserverInterface
{
    protected $giftcardsCollection;
    protected $giftCardsFactory;
    protected $helper;

    public function __construct(
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftcardsCollection,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Helper\Data $helper
    ) {
        $this->giftcardsCollection = $giftcardsCollection;
        $this->giftCardsFactory = $giftCardsFactory;
        $this->helper = $helper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $orderSendEmailStatuses = explode(',', $this->helper->getOrderStatuses());
        $orderActivationStatuses = explode(',', $this->helper->getCardActivationOrderStatuses());


        if (in_array($order->getStatus(), $orderSendEmailStatuses)
            || in_array($order->getStatus(), $orderActivationStatuses)
        ) {
            $cards = $this->giftcardsCollection->create()
                ->addFieldToFilter('order_id', $order->getId())
                ->load();
            
            foreach ($cards as $card) {
                $model = $this->giftCardsFactory->create();
                $model->load($card->getId());

                if (in_array($order->getStatus(), $orderActivationStatuses)) {
                    if ($model->getCardStatus() == \MageWorx\GiftCards\Model\GiftCards::STATUS_INACTIVE) {
                        $model->setCardStatus(\MageWorx\GiftCards\Model\GiftCards::STATUS_ACTIVE);
                        $model->save();
                    }
                }

                if (in_array($order->getStatus(), $orderSendEmailStatuses)) {
                    $model->send($order);
                }
            }
        }
    }
}
