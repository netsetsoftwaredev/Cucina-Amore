/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
/*global define*/
define(
       [
           'Magento_Checkout/js/view/summary/abstract-total',
           'Magento_Checkout/js/model/totals',
           'Magento_Checkout/js/model/quote'
       ],
       function(Component, totalsService, quote) {
           "use strict";
           var quoteData = window.checkoutConfig.quoteData;
           return Component.extend({
                defaults: {
                    template: 'MageWorx_GiftCards/cart/totals/giftcardsdiscount'
                },
            isDisplayed: function () {
                return this.getGiftCardsValue() != 0;
            },
            getCardsCode: function () {
                var cardCode = '';
                var giftcardsTotal = totalsService.getSegment('mageworx_giftcards');
                if (giftcardsTotal) {
                    cardCode = giftcardsTotal.title;
                } else if (quoteData.mageworx_giftcards_description) {
                    cardCode = quoteData.mageworx_giftcards_description;
                }
                return cardCode;
            },
            getGiftCardsValue: function () {
                var price = 0;
                var giftcardsTotal = totalsService.getSegment('mageworx_giftcards');
                if (giftcardsTotal) {
                    price = parseFloat(giftcardsTotal.value);
                } else if (quoteData.mageworx_giftcards_amount) {
                    price = parseFloat(quoteData.mageworx_giftcards_amount);
                }
                return price;
            },
            getValue: function () {
                return this.getFormattedPrice(this.getGiftCardsValue());
            }
           });
        }
);