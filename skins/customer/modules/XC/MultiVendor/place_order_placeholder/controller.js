/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Place order placeholder controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

function PlaceOrderPlaceholderView(base)
{
  var args = Array.prototype.slice.call(arguments, 0);
  if (!base) {
    args[0] = jQuery('.place-order-placeholder').eq(0);
  }

  this.bind('local.postprocess', _.bind(this.assignHandlers, this))
  core.bind('updateCart', _.bind(this.reload, this));
  core.bind('checkout.common.anyChange', _.bind(this.handleAnyFormChange, this));
  core.bind('checkout.common.anyChange', _.bind(this.reload, this));

  PlaceOrderPlaceholderView.superclass.constructor.apply(this, args);
}

extend(PlaceOrderPlaceholderView, ALoadable);

// Shade widget
PlaceOrderPlaceholderView.prototype.shadeWidget = true;

// Update page title
PlaceOrderPlaceholderView.prototype.updatePageTitle = false;

// Widget target
PlaceOrderPlaceholderView.prototype.widgetTarget = 'checkout';

// Widget class name
PlaceOrderPlaceholderView.prototype.widgetClass = '\\XLite\\Module\\XC\\MultiVendor\\View\\Checkout\\PlaceOrderPlaceholder';

// Postprocess widget
PlaceOrderPlaceholderView.prototype.assignHandlers = function(event, state)
{
    this.handleAnyFormChange();
    this.base.find('.remove-items a').click(function(event) {
        core.get(
            URLHandler.buildURL({'target': 'checkout', 'action': 'removeVendorsProducts'}),
            function(xhr, status, data) {},
            {},
            {timeout: 10000}
        ).done(function(data){
            core.trigger('updateCart', {shippingMethodsHash: ''});
            core.bind('checkout.cartItems.loaded', function(){
                jQuery('.review-step .items-row a').click();
            })
        });
        return false;
    });
};

PlaceOrderPlaceholderView.prototype.reload = function(event, data)
{
  this.load();
};

PlaceOrderPlaceholderView.prototype.getOptions = function()
{
    return core.getCommentedData(this.base);
}

// Get event namespace (prefix)
PlaceOrderPlaceholderView.prototype.getEventNamespace = function()
{
  return 'checkout.placeOrderPlaceholder';
};

PlaceOrderPlaceholderView.prototype.handleAnyFormChange = function()
{
    var options = this.getOptions();
    if (options && options.isVisible) {
        jQuery('.checkout-block form.place').hide();
        this.base.show();
        this.base.removeClass('hidden');
    } else {
        jQuery('.checkout-block form.place').show();
        this.base.hide();
    };
};

// Load
core.bind(
  'checkout.main.postprocess',
  function () {
    new PlaceOrderPlaceholderView();
  }
);
