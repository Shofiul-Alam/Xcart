/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

jQuery(function() {
    $('.cycle-cloak.cycle-slideshow').on('cycle-initialized', function(event, opts) {
        $(this).removeClass('.cycle-cloak');
    });
});