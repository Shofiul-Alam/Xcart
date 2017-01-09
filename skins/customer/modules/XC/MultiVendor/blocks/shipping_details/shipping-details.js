/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * order-notes.js
 *
 * Copyright (c) 2001-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

define(
  'multivendor/checkout_fastlane/blocks/shipping_details',
 ['checkout_fastlane/blocks/shipping_details',
  'checkout_fastlane/sections'],
  function(ShippingDetails, Sections) {

  var ShippingDetails = ShippingDetails.extend({

    methods: {
      shippingMethodString: function() {
        return _.reduce(this.order_shipping_method, function(memo, item, key) {
          memo += window.vendorsList[parseInt(key, 10)] + ': ' + window.shippingMethodsList[parseInt(item, 10)] + '<br>';

          return memo;
        }, '');
      }
    },

  });

  Vue.registerComponent(Sections, ShippingDetails);

  return ShippingDetails;
});