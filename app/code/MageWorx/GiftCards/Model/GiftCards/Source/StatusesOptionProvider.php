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
class StatusesOptionProvider implements \Magento\Framework\Data\OptionSourceInterface
{
    public function getAllOptions()
    {
        return [
            \MageWorx\GiftCards\Model\GiftCards::STATUS_INACTIVE => __('Inactive'),
            \MageWorx\GiftCards\Model\GiftCards::STATUS_ACTIVE => __('Active'),
            \MageWorx\GiftCards\Model\GiftCards::STATUS_USED => __('Used'),
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
