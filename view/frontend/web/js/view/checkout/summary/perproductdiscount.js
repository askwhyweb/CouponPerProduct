define([
  "jquery",
  "Magento_Checkout/js/view/summary/abstract-total",
  "Magento_Checkout/js/model/quote",
  "Magento_Catalog/js/price-utils"
], function($, Component, quote, priceUtils) {
  "use strict";
  return Component.extend({
    defaults: {
      template: "OrviSoft_CouponPerProduct/checkout/summary/perproductdiscount"
    },
    getFormattedPrice: function(price) {
      return priceUtils.formatPrice(price, quote.getPriceFormat());
    },
    isDisplayedPerproductDiscount: function() {
      return false;
    },
    getPerproductDiscountValue: function() {
      return "Anything";
    },
    apiData: function() {
      $.ajax({
        url: "/rest//V1/orvisoft-couponperproduct/discountpercoupon/",
        data: { param: 1 },
        type: "GET",
        dataType: "json",
        beforeSend: function() {
          // show some loading icon
        },
        success: function(data, status, xhr) {
          //console.log("API data: ", data);
          if (typeof data[1] === "undefined" || data[2] == false) {
            $(".perproductdiscount").hide();
          }
          if (typeof data[2] !== "undefined" && data[2] == false) {
            $("#product_discount_price").text(
              priceUtils.formatPrice(data[1], quote.getPriceFormat())
            );
            $("#product_discount_labels").text(data[0]);
          }
          $("#product_discount_price").text(
            priceUtils.formatPrice(data[1], quote.getPriceFormat())
          );
          $("#product_discount_labels").text(data[0]);
        },
        error: function(xhr, status, errorThrown) {
          console.log("Error happens. Try again.");
          console.log(errorThrown);
        }
      });
    },
    getPerproductDiscount: function() {
      this.apiData();
      return "-";
    }
  });
});
