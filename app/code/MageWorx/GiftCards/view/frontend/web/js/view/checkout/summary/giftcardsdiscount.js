define(
       [
           'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote'
       ],
       function(Component, quote) {
           "use strict";
           return Component.extend({
                defaults: {
                    template: 'MageWorx_GiftCards/checkout/summary/giftcardsdiscount'
                },
            totals: quote.getTotals(),
            isDisplayed: function () {
                return this.getGiftCardsValue() != 0;
            },
            getCardsCode: function () {
                if (!this.totals()) {
                    return null;
                }
                return this.totals()['giftcards_code'];
            },
            getGiftCardsValue: function () {
                var price = 0;
                if (this.totals() && this.totals().mageworx_giftcards) {
                    price = parseFloat(this.totals().mageworx_giftcards);
                }
                return price;
            },
            getValue: function () {
                return this.getFormattedPrice(this.getGiftCardsValue());
            }
           });
        }
);