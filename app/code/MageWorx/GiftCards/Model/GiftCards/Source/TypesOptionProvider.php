<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\GiftCards\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * @codeCoverageIgnore
 */
class TypesOptionProvider implements \Magento\Framework\Data\OptionSourceInterface
{

    public function getAllOptions()
    {
        return [
            \MageWorx\GiftCards\Model\GiftCards::TYPE_EMAIL => __('Email'),
            \MageWorx\GiftCards\Model\GiftCards::TYPE_PRINT => __('Print'),
            \MageWorx\GiftCards\Model\GiftCards::TYPE_OFFLINE => __('Offline'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $types = [];
        foreach ($this->getAllOptions() as $value => $label) {
            $types[] = ['label' => $label, 'value' => $value];
        }
        return $types;
    }
}
