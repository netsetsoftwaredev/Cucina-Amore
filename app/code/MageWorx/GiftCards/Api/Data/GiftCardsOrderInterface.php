<?php
/**
 *
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Api\Data;

interface GiftCardsOrderInterface
{

    const ENTITY_ID          = 'entity_id';
    const GIFTCARD_ID        = 'giftcard_id';
    const ORDER_ID           = 'order_id';
    const DISCOUNTED         = 'discounted';
    const CREATED_TIME       = 'created_time';
    const UPDATED_AT         = 'updated_at';

    /**
     * @return int|null
     */
    public function getId();
    
    /**
     * @return int|null
     */
    public function getCardId();
    
    /**
     * @return int|null
     */
    public function getOrderId();
    
    /**
     * @return float|null
     */
    public function getDiscounted();
    
    /**
     * @return date|null
     */
    public function getCreatedTime();
    
    /**
     * @return date|null
     */
    public function getUpdatedAt();
    
    /**
     * @param int
     * @return $this
     */
    public function setId($id);
    
    /**
     * @param int
     * @return $this
     */
    public function setCardId($cardId);
    
    /**
     * @param int
     * @return $this
     */
    public function setOrderId($orderId);
    
    /**
     * @param float
     * @return $this
     */
    public function setDiscounted($discounted);
    
    /**
     * @param date
     * @return $this
     */
    public function setCreatedTime($createdTime);
    
    /**
     * @param date
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
