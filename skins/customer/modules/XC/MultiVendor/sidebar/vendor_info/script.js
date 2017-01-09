/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Vendor about info loader
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

jQuery(function () {
  function loadPopup(event) {
    loadDialogByLink(
      event.currentTarget,
      URLHandler.buildURL({
        'target': 'vendor',
        'action': 'about',
        'widget': '\\XLite\\Module\\XC\\MultiVendor\\View\\AboutVendor',
        'vendor_id': jQuery(event.currentTarget).data('vendor-id')
      }),
      {width: 'auto'},
      null,
      this
    );

    return false;
  }

  core.microhandlers.add('aboutVendorPopup', '.vendor-about-popup', function () {
    jQuery(this).click(loadPopup);
  });
});

