/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Product filter
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

(function () {
  var postprocess = ProductFilterView.prototype.postprocess;

  ProductFilterView.prototype.postprocess = function (isSuccess) {
    if (isSuccess) {
      jQuery('.product-filter a.reset-filter').click(
        function () {
          jQuery('.product-filter .type-vendor').find('select').each(function () {
            jQuery(this).val('').change();
          });

          return true;
        }
      );

      jQuery('.product-filter .type-vendor select').change(
        function () {
          var popup = jQuery('.product-filter .popup');
          popup.css('top', jQuery(this).offset().top - jQuery('.product-filter').offset().top - 60).show();
          clearTimeout(popup.attr('timerId'));
          popup.attr('timerId', setTimeout("jQuery('.product-filter .popup').hide()", 4000));
        }
      );
    }

    if (typeof postprocess == 'function') {
      postprocess.apply(this, [isSuccess]);
    }
  };
})();
