/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Vendor account form sticky panel controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

function StickyPanelVendorAccount()
{
  StickyPanel.apply(this, arguments);
  this.initialize();
}

extend(StickyPanelVendorAccount, StickyPanel);

StickyPanelVendorAccount.autoload = function()
{
  jQuery('form.profile-form .model-properties .sticky-panel.form-change-activation').each(
    function() {
      new StickyPanelVendorAccount(this);
    }
  );
};

// Initialize popover control
StickyPanelVendorAccount.prototype.initialize = function()
{
  jQuery('.sticky-panel .box .decline-vendor-link button.open-popover').popover({
    html:      true,
    placement: 'right',
    content:   this.getPopoverHTML
  });

  jQuery('.sticky-panel .box .decline-vendor-link button.open-popover')
    .on('shown.bs.popover', _.bind(this.handleShowPopover, this))
    .on('hidden.bs.popover', _.bind(this.handleHidePopover, this));

  jQuery('.popover .close').click(_.bind(this.handlePopoverClose, this));
}

// Get content for popover container
StickyPanelVendorAccount.prototype.getPopoverHTML = function()
{
  return jQuery('.sticky-panel .box .decline-vendor-dialog').html();
}

// Handle popover visibility change
StickyPanelVendorAccount.prototype.handleShowPopover = function(event)
{
  jQuery('.popover').click(
    function(event) {
      event.stopPropagation();
    }
  );

  jQuery('.popover .close').click(_.bind(this.handlePopoverClose, this));
}

// Handle popover close
StickyPanelVendorAccount.prototype.handlePopoverClose = function(event)
{
  jQuery('.sticky-panel .box .decline-vendor-link button.open-popover').popover('hide');

  return false;
}

// Autoload
core.microhandlers.add(
  'StickyPanelVendorAccount',
  'form.profile-form .model-properties .sticky-panel.form-change-activation',
  function () {
    core.autoload(StickyPanelVendorAccount);
  }
);
