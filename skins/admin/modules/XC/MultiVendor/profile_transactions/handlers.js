/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Handlers
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */
var elementsToBind = ['.cell.debit', '.cell.credit'];

var getOppositeElements = function($element) {
  var ownerTr = $element.closest('tr');
  var elements = _.map(elementsToBind, function(el, index) {
    return jQuery(el + ' input', ownerTr);
  });

  return _.reject(elements, function(otherElement) {
    return $element.get(0) === otherElement.get(0);
  });
};

var disableAllInTr = function (tr) {
  _.each(elementsToBind, _.bind(
    function (element){
      jQuery(tr).find(element).find('input').attr('disabled', 'disabled');
    }, this)
  );
};

var enableAllInTr = function (tr) {
  _.each(elementsToBind, _.bind(
    function (element){
      jQuery(tr).find(element).find('input').removeAttr('disabled');
    }, this)
  );
};

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return _.some(elementsToBind, _.bind(
        function (element) {
          return this.$element.parents(element).length != 0;
        },
        this)
      );
    },
    handler: function () {
     this.$element.keydown(function (evt) {
        var $input = jQuery(this);
        var ownerTr = $input.closest('tr');
        if (parseFloat($input.val()) > 0) {
          var opposites = getOppositeElements($input);
          _.each(opposites, function(el, index) {
            el.attr('disabled', 'disabled');
          });
        }
      });
      this.$element.change(function (evt) {
        var $input = jQuery(this);
        var ownerTr = $input.closest('tr');
        if (parseFloat($input.val()) > 0) {
          var opposites = getOppositeElements($input);
          _.each(opposites, function(el, index) {
            el.removeAttr('disabled');
            el.closest('.cell').find('.view .symbol').addClass('hidden');
            el.val(0);
          });
        }
      });
    }
  }
);

core.bind(
  'list.model.table.line.new.add',
  function () {
    var newElement = jQuery('.list .create .dump-entity .cell.profile .subfield-profile select');

    var selectedProfile = $('.xc-multivendor-searchpanel-profiletransactions-main .profile-condition select[name="profile"]').val();
    newElement.val(selectedProfile);

    newElement = newElement.last();
    newElement.data('jqv', {validateNonVisibleFields: true});
    newElement.chosen();
    newElement.next('.chosen-container').css('min-width', newElement.parents('.cell').width());

    newElement.bind('invalid', function () {
      jQuery(this).siblings('.chosen-container').find('input').get(0).click();
    });

    jQuery('.chosen-container .search-choice').live('click', function () {
      jQuery('.search-choice-close', this).trigger('click.chosen');
    });

  }
);

ItemsList.prototype.listeners.modifyCreateTransactionButtonState = function (handler) {
  var button = $('.profile-transaction.items-list .list-header .button-container button.create-inline');
  var vendorSelect = $('.xc-multivendor-searchpanel-profiletransactions-main .profile-condition select[name="profile"]');

  if (vendorSelect.val()) {
    button
      .removeClass('disabled')
      .removeProp('disabled')
      .prop('title', '');
  } else {
    button
      .addClass('disabled')
      .prop('disabled', 'disabled')
      .prop('title', core.t('Select the vendor profile to add a transaction'));
  }

  vendorSelect.change(function () {
    var button = $('.profile-transaction.items-list .list-header .button-container button.create-inline');
    if ($(this).val()) {
      button
        .removeClass('disabled')
        .removeProp('disabled')
        .prop('title', '');
    } else {
      button
        .addClass('disabled')
        .prop('disabled', 'disabled')
        .prop('title', core.t('Select the vendor profile to add a transaction'));
    }
  });
};
