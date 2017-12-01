<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model;

use MageWorx\GiftCards\Api\Data\GiftCardsOrderInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Order extends \Magento\Framework\Model\AbstractModel implements GiftCardsOrderInterface, IdentityInterface
{
    
    const CACHE_TAG          = 'mageworx_giftcards_order';
    
    protected $cacheTag     = 'mageworx_giftcards_order';
    
    protected $eventPrefix  = 'mageworx_giftcards_order';
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('MageWorx\GiftCards\Model\ResourceModel\Order');
    }

    public function getIdentities()
    {
        return [self::CAСHE_TAG . '_' . $this->getId()];
    }
    
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    
    public function getCardId()
    {
        return $this->getData(self::GIFTCARD_ID);
    }
    
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }
    
    public function getDiscounted()
    {
        return $this->getData(self::DISCOUNTED);
    }
    
    public function getCreatedTime()
    {
        return $this->getData(self::CREATED_TIME);
    }
    
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
    
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
    
    public function setCardId($cardId)
    {
        return $this->setData(self::GIFTCARD_ID, $cardId);
    }
    
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }
    
    public function setDiscounted($discounted)
    {
        return $this->setData(self::DISCOUNTED, $discounted);
    }
    
    public function setCreatedTime($createdTime)
    {
        return $this->setData(self::CREATED_TIME, $createdTime);
    }
    
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
