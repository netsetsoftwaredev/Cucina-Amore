<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\Product\Type;

class Price extends \Magento\Catalog\Model\Product\Type\Price
{
    /**
     * Apply options price
     *
     * @param Product $product
     * @param int $qty
     * @param float $finalPrice
     * @return float
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _applyOptionsPrice($product, $qty, $finalPrice)
    {
        if ($product->getCustomOption('card_amount') && $product->getPrice() == 0) {
            $amount = $product->getCustomOption('card_amount')->getValue();
            $finalPrice += $amount;
        }
        return $finalPrice;
    }
}
