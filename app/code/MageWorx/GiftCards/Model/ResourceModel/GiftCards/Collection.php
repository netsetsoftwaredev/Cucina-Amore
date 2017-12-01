<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\ResourceModel\GiftCards;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('MageWorx\GiftCards\Model\GiftCards', 'MageWorx\GiftCards\Model\ResourceModel\GiftCards');
    }
}
