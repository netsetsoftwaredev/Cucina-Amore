/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
/*global define*/
define(
    [
        'MageWorx_GiftCards/js/view/cart/totals/giftcardsdiscount',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote'
    ],
    function (Component, quote) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'MageWorx_GiftCards/summary/mageworxgiftcards'
            },
        });
    }
);
