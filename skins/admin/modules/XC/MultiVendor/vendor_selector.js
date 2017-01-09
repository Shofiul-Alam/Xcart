/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Review email field microcontroller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

core.microhandlers.add(
  'VendorSelector',
  '#vendor',
  function (event) {
    var input = jQuery('#vendor').get(0);

    jQuery(input).on('autocompleteselect', function (event, ui) {
      jQuery.each(input._data, function (index, value) {
        if (value.label.name == ui.item.value) {
          jQuery(input.form).find('[name="vendorId"]:hidden').val(value.value);

          return;
        }
      });

      input.form.submit();
    });
  }
);
