<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\GiftCards\Source;

class Types extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        return [
            ['value' => \MageWorx\GiftCards\Model\GiftCards::TYPE_EMAIL, 'label' => __('Email')],
            ['value' => \MageWorx\GiftCards\Model\GiftCards::TYPE_PRINT, 'label' => __('Print')],
            ['value' => \MageWorx\GiftCards\Model\GiftCards::TYPE_OFFLINE, 'label' => __('Offline')],
        ];
    }
}
