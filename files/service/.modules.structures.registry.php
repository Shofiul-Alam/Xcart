# <?php if (!defined('LC_DS')) { die(); } ?>

Amazon\PayWithAmazon:
  tables: {  }
  columns: { profiles: { socialLoginProvider: 'socialLoginProvider VARCHAR(128) DEFAULT NULL', socialLoginId: 'socialLoginId VARCHAR(128) DEFAULT NULL' } }
  dependencies: {  }
CDev\AuthorizeNet:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\Bestsellers:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\ContactUs:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\Coupons:
  tables: [coupons, product_class_coupons, membership_coupons, coupon_categories, order_coupons]
  columns: {  }
  dependencies: {  }
CDev\FeaturedProducts:
  tables: [featured_products]
  columns: {  }
  dependencies: {  }
CDev\FedEx:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\GoogleAnalytics:
  tables: {  }
  columns: { order_items: { categoryAdded: 'categoryAdded VARCHAR(255) DEFAULT NULL' }, profiles: { gaClientId: 'gaClientId VARCHAR(255) NOT NULL' } }
  dependencies: {  }
CDev\GoSocial:
  tables: {  }
  columns: { categories: { ogMeta: 'ogMeta LONGTEXT NOT NULL', useCustomOG: 'useCustomOG TINYINT(1) NOT NULL' }, pages: { ogMeta: 'ogMeta LONGTEXT NOT NULL', showSocialButtons: 'showSocialButtons TINYINT(1) NOT NULL' }, products: { ogMeta: 'ogMeta LONGTEXT NOT NULL', useCustomOG: 'useCustomOG TINYINT(1) NOT NULL' } }
  dependencies: { CDev\SimpleCMS: { pages: { ogMeta: 'ogMeta LONGTEXT NOT NULL', showSocialButtons: 'showSocialButtons TINYINT(1) NOT NULL' } } }
CDev\Moneybookers:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\Paypal:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\ProductAdvisor:
  tables: [product_stats]
  columns: {  }
  dependencies: {  }
CDev\Quantum:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\Sale:
  tables: {  }
  columns: { products: { participateSale: 'participateSale TINYINT(1) NOT NULL', discountType: 'discountType VARCHAR(32) NOT NULL', salePriceValue: 'salePriceValue NUMERIC(14, 4) NOT NULL' } }
  dependencies: {  }
CDev\SalesTax:
  tables: [sales_tax_rates, sales_taxes, sales_tax_translations]
  columns: {  }
  dependencies: {  }
CDev\SimpleCMS:
  tables: [page_images, menu_quick_flags, menus, menu_translations, pages, page_translations]
  columns: { clean_urls: { page_id: 'page_id INT UNSIGNED DEFAULT NULL' } }
  dependencies: {  }
CDev\SocialLogin:
  tables: {  }
  columns: { profiles: { pictureUrl: 'pictureUrl VARCHAR(255) DEFAULT NULL' } }
  dependencies: {  }
CDev\TwoCheckout:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\UserPermissions:
  tables: {  }
  columns: { permissions: { enabled: 'enabled TINYINT(1) NOT NULL' }, roles: { enabled: 'enabled TINYINT(1) NOT NULL' } }
  dependencies: {  }
CDev\USPS:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\VolumeDiscounts:
  tables: [volume_discounts]
  columns: {  }
  dependencies: {  }
CDev\XMLSitemap:
  tables: {  }
  columns: {  }
  dependencies: {  }
CDev\XPaymentsConnector:
  tables: [xpc_payment_fraud_check_data, xpc_payment_transaction_data]
  columns: { orders: { fraud_status_xpc: 'fraud_status_xpc VARCHAR(255) NOT NULL', fraud_type_xpc: 'fraud_type_xpc VARCHAR(255) NOT NULL', fraud_check_transaction_id: 'fraud_check_transaction_id INT NOT NULL' }, order_items: { xpcFakeItem: 'xpcFakeItem TINYINT(1) NOT NULL' }, profiles: { default_card_id: 'default_card_id INT UNSIGNED NOT NULL', pending_zero_auth: 'pending_zero_auth VARCHAR(255) NOT NULL', pending_zero_auth_txn_id: 'pending_zero_auth_txn_id VARCHAR(255) NOT NULL', pending_zero_auth_status: 'pending_zero_auth_status CHAR(1) NOT NULL', pending_zero_auth_interface: 'pending_zero_auth_interface VARCHAR(255) NOT NULL' } }
  dependencies: {  }
QSL\CloudSearch:
  tables: {  }
  columns: {  }
  dependencies: {  }
QSL\FlyoutCategoriesMenu:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\AuctionInc:
  tables: [product_auction_inc]
  columns: { orders: { auctionIncPackage: 'auctionIncPackage LONGTEXT DEFAULT NULL COMMENT ''(DC2Type:array)''' }, shipping_methods: { onDemand: 'onDemand TINYINT(1) NOT NULL' } }
  dependencies: {  }
XC\BulkEditing:
  tables: {  }
  columns: { products: { xcPendingBulkEdit: 'xcPendingBulkEdit TINYINT(1) NOT NULL' } }
  dependencies: {  }
XC\CanadaPost:
  tables: [k, capost_delivery_service_options, capost_delivery_services, order_capost_parcel_items, order_capost_parcel_manifest_link_storage, order_capost_parcel_manifest_links, order_capost_parcel_manifests, order_capost_parcel_shipments_manifests, order_capost_parcel_shipment_link_storage, order_capost_parcel_shipment_links, order_capost_parcel_shipment_tracking_options, order_capost_parcel_shipment_tracking_files, order_capost_parcel_shipment_tracking_events, order_capost_parcel_shipment_tracking, order_capost_parcel_shipment, order_capost_parcels, order_capost_office, capost_return_items, capost_return_link_storage, capost_return_links, capost_returns]
  columns: {  }
  dependencies: {  }
XC\CrispWhiteSkin:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\EPDQ:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\FastLaneCheckout:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\FreeShipping:
  tables: {  }
  columns: { products: { freeShip: 'freeShip TINYINT(1) NOT NULL', freightFixedFee: 'freightFixedFee NUMERIC(14, 4) NOT NULL' }, shipping_methods: { free: 'free TINYINT(1) NOT NULL' } }
  dependencies: {  }
XC\FroalaEditor:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\IdealPayments:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\MailChimp:
  tables: [mailchimp_list_group, mailchimp_list_group_name, mailchimp_profile_interests, mailchimp_lists, mailchimp_subscriptions, mailchimp_list_segments, segment_membership, segment_products, mailchimp_segment_subscriptions, mailchimp_store]
  columns: { products: { useAsSegmentCondition: 'useAsSegmentCondition TINYINT(1) NOT NULL' } }
  dependencies: {  }
XC\News:
  tables: [news, news_message_translations]
  columns: { clean_urls: { news_message_id: 'news_message_id INT UNSIGNED DEFAULT NULL' } }
  dependencies: {  }
XC\NewsletterSubscriptions:
  tables: [newsletter_subscriptions_subscribers]
  columns: {  }
  dependencies: {  }
XC\Reviews:
  tables: [reviews]
  columns: {  }
  dependencies: {  }
XC\SagePay:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\Stripe:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\ThemeTweaker:
  tables: [theme_tweaker_template]
  columns: { view_lists: { list_override: 'list_override VARCHAR(255) NOT NULL', weight_override: 'weight_override INT NOT NULL', override_mode: 'override_mode INT NOT NULL' } }
  dependencies: {  }
XC\UpdateInventory:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\UPS:
  tables: {  }
  columns: {  }
  dependencies: {  }
XC\Upselling:
  tables: [upselling_products]
  columns: {  }
  dependencies: {  }
XC\MultiVendor:
  tables: [commission, vendor_images, profile_transaction, vendor, vendor_translations]
  columns: { attributes: { vendor_id: 'vendor_id INT DEFAULT NULL' }, attribute_groups: { vendor_id: 'vendor_id INT DEFAULT NULL' }, clean_urls: { vendor_id: 'vendor_id INT DEFAULT NULL' }, config: { vendor_id: 'vendor_id INT DEFAULT NULL' }, order_surcharges: { vendor_id: 'vendor_id INT DEFAULT NULL' }, orders: { parent_id: 'parent_id INT DEFAULT NULL', vendor_id: 'vendor_id INT DEFAULT NULL', commission_id: 'commission_id INT UNSIGNED DEFAULT NULL' }, order_items: { vendor_id: 'vendor_id INT DEFAULT NULL', originalProductId: 'originalProductId INT UNSIGNED DEFAULT NULL' }, order_tracking_number: { vendor_id: 'vendor_id INT DEFAULT NULL' }, products: { vendor_id: 'vendor_id INT DEFAULT NULL' }, product_classes: { vendor_id: 'vendor_id INT DEFAULT NULL' }, profiles: { vendorConfig: 'vendorConfig LONGTEXT DEFAULT NULL COMMENT ''(DC2Type:array)''', paypalLogin: 'paypalLogin VARCHAR(255) DEFAULT NULL', firstName: 'firstName VARCHAR(255) DEFAULT NULL', lastName: 'lastName VARCHAR(255) DEFAULT NULL', paypalLoginStatus: 'paypalLoginStatus CHAR(1) NOT NULL', bankDetails: 'bankDetails LONGTEXT DEFAULT NULL', lastShippingIdByVendor: 'lastShippingIdByVendor LONGTEXT DEFAULT NULL COMMENT ''(DC2Type:array)''', specialRevshareFeeDst: 'specialRevshareFeeDst NUMERIC(14, 4) DEFAULT NULL', hasSpecialRevshareFeeDst: 'hasSpecialRevshareFeeDst TINYINT(1) NOT NULL', specialRevshareFeeShipping: 'specialRevshareFeeShipping NUMERIC(14, 4) DEFAULT NULL', hasSpecialRevshareFeeShipping: 'hasSpecialRevshareFeeShipping TINYINT(1) NOT NULL' }, shipping_methods: { vendor_id: 'vendor_id INT DEFAULT NULL' }, coupons: { vendor_id: 'vendor_id INT DEFAULT NULL' }, volume_discounts: { vendor_id: 'vendor_id INT DEFAULT NULL' } }
  dependencies: {  }
Shofi\ToolListing:
  tables: [product_aprice, product_location, product_extra_details]
  columns: {  }
  dependencies: {  }
Shofi\AdvanceRegistration:
  tables: {  }
  columns: {  }
  dependencies: {  }
