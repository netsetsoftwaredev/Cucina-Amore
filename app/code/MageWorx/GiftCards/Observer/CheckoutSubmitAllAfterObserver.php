<?php
/**
 * Copyright © 2017 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Observer;

use Magento\Framework\Event\ObserverInterface;
use MageWorx\GiftCards\Model\GiftCards;

class CheckoutSubmitAllAfterObserver implements ObserverInterface
{
    protected $giftCardsSession;
    protected $giftCardsCollection;
    protected $giftCardsOrderCollection;
    protected $giftCardsRepository;
    protected $giftCardsOrderRepository;
    protected $giftCardsFactory;
    protected $giftCardsOrderFactory;
    protected $helper;
    protected $logger;

    public function __construct(
        \MageWorx\GiftCards\Model\Session $giftcardsSession,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftcardsCollection,
        \MageWorx\GiftCards\Model\ResourceModel\Order\CollectionFactory $giftcardsOrderCollection,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository,
        \MageWorx\GiftCards\Model\OrderRepository $giftCardsOrderRepository,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Model\OrderFactory $giftCardsOrderFactory,
        \MageWorx\GiftCards\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->giftCardsSession = $giftcardsSession;
        $this->giftCardsCollection = $giftcardsCollection;
        $this->giftCardsOrderCollection = $giftcardsOrderCollection;
        $this->giftCardsRepository = $giftCardsRepository;
        $this->giftCardsOrderRepository = $giftCardsOrderRepository;
        $this->giftCardsFactory = $giftCardsFactory;
        $this->giftCardsOrderFactory = $giftCardsOrderFactory;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();

        if (!$order && $observer->getOrders()) {
            $orders = $observer->getOrders();
            $order = $orders[0];
        }

        $quote = $observer->getQuote();

        foreach ($quote->getAllVisibleItems() as $item) {
            $product = $item->getProduct();
            if ($product->getTypeId() == 'mageworx_giftcards') {
                $options = $product->getCustomOptions();
                $optionsDataMap = [
                            'card_type',
                            'mail_to',
                            'mail_to_email',
                            'mail_from',
                            'mail_message',
                            'offline_country',
                            'offline_state',
                            'offline_city',
                            'offline_street',
                            'offline_zip',
                            'offline_phone',
                            'mail_delivery_date',
                            'card_currency'
                        ];
                
                $data = [];
                foreach ($optionsDataMap as $field) {
                    if (isset($options[$field])) {
                        $data[$field] = $options[$field]->getValue();
                    }
                }
                $data['card_amount'] = $item->getCalculationPrice()+$item->getTaxAmount();
                $data['product_id'] = $product->getId();
                $data['card_status'] = GiftCards::STATUS_INACTIVE;
                $data['order_id'] = $order->getId();

                $orderSendEmailStatuses  = explode(',', $this->helper->getOrderStatuses());
                $orderActivationStatuses = explode(',', $this->helper->getCardActivationOrderStatuses());

                $orderItem = $order->getItemByQuoteItemId($item->getId());
                $productName = $orderItem->getName();
                for ($i = 0; $i < $item->getQty(); $i++) {
                    $model = $this->giftCardsFactory->create();
                    $model->setData($data);

                    if (in_array($order->getStatus(), $orderActivationStatuses)) {
                        $model->setCardStatus(GiftCards::STATUS_ACTIVE);
                    } else {
                        $model->setCardStatus(GiftCards::STATUS_INACTIVE);
                    }

                    $giftCard = $this->giftCardsRepository->save($model);

                    if (in_array($order->getStatus(), $orderSendEmailStatuses)) {
                        $giftCard->send($order);
                    }
                    $productName .= ', ' . $giftCard->getCardCode();
                }
                if ($this->helper->getAddCodeToProduct()) {
                    $orderItem->setName($productName);
                    $orderItem->save();
                }
            }
        }

        if ((bool)$this->giftCardsSession->getActive() === true && $giftCardsIds = $this->giftCardsSession->getGiftCardsIds()) {
            $ids = array_keys($giftCardsIds);
            $frontOptions = $this->giftCardsSession->getFrontOptions();

            foreach ($ids as $card_id) {
                $card = $this->giftCardsRepository->get($card_id);

                $oGiftCardOrder = $this->giftCardsOrderFactory->create();

                $useAmount = $frontOptions[$card_id]['applied'];
                if ($useAmount > 0) {
                    $card->setCardBalance($frontOptions[$card->getId()]['remaining']);

                    if ($card->getCardBalance() == 0) {
                        $card->setCardStatus(GiftCards::STATUS_USED); //set status to 'used' when gift card balance is 0;
                    }

                    $card = $this->giftCardsRepository->save($card);

                    $oGiftCardOrder->setGiftcardId($card->getId());
                    $oGiftCardOrder->setOrderId($order->getId());
                    $oGiftCardOrder->setDiscounted((float)$useAmount);
                    $this->giftCardsOrderRepository->save($oGiftCardOrder);
                }
            }
            $order->setMageworxGiftcardsAmount($quote->getMageworxGiftcardsAmount());
            $order->setBaseMageworxGiftcardsAmount($quote->getBaseMageworxGiftcardsAmount());
            $order->setMageworxGiftcardsDescription($quote->getMageworxGiftcardsDescription());
            $order->save();
        }
        $this->giftCardsSession->setActive(0);
        $this->giftCardsSession->setFrontOptions(null);
        $this->giftCardsSession->setGiftCardsIds(null);
        return $this;
    }
}
