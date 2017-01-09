/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Vendor field controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

var initializeChosen = function(select, options) {
  select.chosen(options);
  select.next('.chosen-container').css('width', select.outerWidth());
}

var tryInitializeWidget = function(select) {
 if (select.length > 0) {
    initializeChosen(
      select,
      {
        disable_search_threshold: 10,
        search_contains: true
      }
    );
  };
}

jQuery(function () {
  var field = jQuery('.inline-field.product-vendor');
  field.bind('startEditInline', function () {
    jQuery(this).next('.orders-present').show();
  });

  tryInitializeWidget(field.find('select'));
});
