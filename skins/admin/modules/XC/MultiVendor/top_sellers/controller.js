/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Top sellers controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

(function () {
  var postprocess = TopSellers.prototype.postprocess;

  TopSellers.prototype.postprocess = function (isSuccess, initial) {
    if (isSuccess) {
      $('form.vendor-fake-form', this.base).each(function () {
        var cc = $(this).get(0).commonController;

        if (_.isUndefined(cc)) {
          new CommonForm($(this));
        }

        $(this).submit(function () {
          return false;
        })
      });

      $('.top-sellers-selectors.vendor-selector .reset a', this.base).click(function () {
        core.trigger('update-top-sellers', {vendorId: ''});

        return false;
      });

      core.microhandlers.add(
        'VendorSelector',
        '#vendor',
        function (event) {
          var input = jQuery('#vendor').get(0);
          var result_value = null;

          jQuery(input).on('autocompleteselect', function (event, ui) {
            jQuery.each(input._data, function (index, value) {
              if (value.label.name == ui.item.value) {
                result_value = value.value;
                return;
              }
            });

            core.trigger('update-top-sellers', {vendorId: result_value});
          });
        }
      );
    }

    if (typeof postprocess == 'function') {
      postprocess.apply(this, [isSuccess, initial]);
    }
  };
})();
