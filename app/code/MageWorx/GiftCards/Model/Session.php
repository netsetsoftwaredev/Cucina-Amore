<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model;

class Session extends \Magento\Framework\Session\SessionManager
{
    public function getCards()
    {
        if (!$this->getData('cards')) {
            return [];
        } else {
            return $this->getData('cards');
        }
    }
}
