/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * shipping-methods.js
 *
 * Copyright (c) 2001-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

define(
  'multivendor/checkout_fastlane/blocks/shipping_methods',
  ['checkout_fastlane/blocks/shipping_methods',
   'checkout_fastlane/sections/shipping'],
  function(ShippingMethods, ShippingSection){
    
    var parent_data = ShippingMethods.options.data;
    var parent_methods_toDataObject = ShippingMethods.options.methods.toDataObject;

    var ShippingMethods = ShippingMethods.extend({

      data: function() {
        return _.extend(parent_data.apply(this, arguments), {
          methodId: window.WidgetData[this.$options.name]['methodId'],
        });
      },

      ready: function() {
        this.triggerUpdate({
          silent: true
        });
      },

      watch: {
        'methodId': {
          deep: true,
          handler: function(value, oldValue){
            this.$root.$broadcast('reloadingBlock', 1);
            this.triggerUpdate();
          }
        }
      },

    });    

    Vue.registerComponent(ShippingSection, ShippingMethods);

    return ShippingMethods;

  });
