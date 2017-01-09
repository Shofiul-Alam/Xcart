/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

define('modules/XC/MultiVendor/form_model/product/info', ['js/vue/vue', 'form_model'], function (XLiteVue) {

  XLiteVue.component('xlite-form-model', {
    props: ['vendorEdited'],
    methods: {
      setVendorEdited: function () {
        this.vendorEdited = true;
      },
      isVendorEdited: function () {
        return this.vendorEdited;
      }
    }
  });

});
