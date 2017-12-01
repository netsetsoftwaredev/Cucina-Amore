<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\GiftCards\Backend;

class AdditionalPrice extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    public function validate($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        $value = $object->getData($attrCode);
        $price = $object->getData('price');
        if (!($price > 0)) {
            if (!preg_match('/(^\d+(\.{0,1}\d{0,})(;\d+(\.{0,1}\d{0,}))+$)|^$/', $value)) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Not correct value. Example: 100;200.33;300.56')
                );
            }
        }
        return true;
    }
}
