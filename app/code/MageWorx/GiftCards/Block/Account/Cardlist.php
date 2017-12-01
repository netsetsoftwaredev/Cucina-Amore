<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Account ;

/**
 * Giftcards history block
 */
class Cardlist extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $giftcardsCollectionFactory;
    protected $giftcardsResourceModel;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /** @var \Magento\Sales\Model\ResourceModel\Order\Collection */
    protected $giftcards;
    
    protected $orderRepository;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftcardsCollectionFactory,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards $giftcardsResourceModel,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->giftcardsCollectionFactory = $giftcardsCollectionFactory;
        $this->giftcardsResourceModel = $giftcardsResourceModel;
        $this->customerSession = $customerSession;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->pageConfig->getTitle()->set(__('My Gift Cards'));
    }

    /**
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getGiftcards()
    {
        if (!$this->customerSession->getCustomerId()) {
            return false;
        }
        $customerEmail = $this->customerSession->getCustomer()->getEmail();
        
        if (!$this->giftcards) {
            $this->giftcards = $this->giftcardsCollectionFactory->create()->addFieldToFilter(
                'mail_to_email',
                $customerEmail
            )->setOrder(
                'created_time',
                'desc'
            );
        }
        return $this->giftcards;
    }

    public function getOrders()
    {
        if (!$this->customerSession->getCustomerId()) {
            return false;
        }
        $customerEmail = $this->customerSession->getCustomer()->getEmail();
        $orders = $this->giftcardsResourceModel->loadCustomerCardsWithOrders($customerEmail);

        return $orders;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getGiftcards()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'giftcards.list.pager'
            )->setCollection(
                $this->getGiftcards()
            );
            $this->setChild('pager', $pager);
            $this->getGiftcards()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @param object $order
     * @return string
     */
    public function getViewUrl($orderId)
    {
        return $this->getUrl('sales/order/view', ['order_id' => $orderId]);
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('customer/account/');
    }
    
    public function getRealOrderId($orderId)
    {
        $order = $this->orderRepository->get($orderId);

        if ($order && $order->getId()) {
            return $order->getIncrementId();
        }
        return '';
    }
    
    public function formatPrice($amount)
    {
        return $amount;
    }
}
