define([
  "jquery",
  "Magento_Checkout/js/view/summary/abstract-total",
  "Magento_Checkout/js/model/quote"
], function($, Component, quote) {
  "use strict";
  return Component.extend({
    defaults: {
      template: "OrviSoft_CouponPerProduct/checkout/summary/perproductdiscount"
    },
    totals: quote.getTotals(),
    isDisplayedPerproductDiscount: function() {
      return true;
    },
    getPerproductDiscount: function() {
      console.log("Data Orders", this.totals());
      //console.log("Abstract-total have following objects", Component);
      return "$10";
    }
  });
});
