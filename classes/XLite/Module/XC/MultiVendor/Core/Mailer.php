<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

use XLite\Core;

/**
 * Database
 */
class Mailer extends \XLite\Core\Mailer implements \XLite\Base\IDecorator
{
     const TYPE_PROFILE_CREATED_USER = 'siteAdmin';

    /**
     * Send notification about updated profile to the user
     *
     * @param \XLite\Model\Profile $profile    Profile object
     * @param string               $password   Profile password OPTIONAL
     * @param boolean              $byCheckout By checkout flag OPTIONAL
     *
     * @return void
     */
    public static function sendProfileUpdatedUserNotification(
        \XLite\Model\Profile $profile,
        $password = null,
        $byCheckout = false
    ) {
        if (!\XLite\Controller\Admin\Profile::isApprovedStateChanged()) {
            parent::sendProfileUpdatedUserNotification($profile, $password, $byCheckout);
        }
    }

    /**
     * Send notification about created vendor profile to the user
     *
     * @param \XLite\Model\Profile $profile    Profile object
     * @param string               $password   Profile password OPTIONAL
     *
     * @return void
     */
    public static function sendVendorCreatedUserNotification(\XLite\Model\Profile $profile, $password = null)
    {
        // Register variables
        static::register('profile', $profile);
        static::register('password', $password);

        // Compose and send email
        static::compose(
            static::TYPE_PROFILE_CREATED_USER,
            static::getSiteAdministratorMail(),
            $profile->getLogin(),
            'modules/XC/MultiVendor/vendor_signin_notification',
            array(),
            true,
            \XLite::CUSTOMER_INTERFACE,
            static::getMailer()->getLanguageCode(\XLite::CUSTOMER_INTERFACE, $profile->getLanguage())
        );
    }

    /**
     * Send notification about created vendor profile to the users department
     *
     * @param \XLite\Model\Profile $profile Profile object
     *
     * @return void
     */
    public static function sendVendorCreatedAdminNotification(\XLite\Model\Profile $profile)
    {
        static::register('profile', $profile);

        $url = \XLite::getInstance()->getShopURL(
            \XLite\Core\Converter::buildURL(
                'profile',
                '',
                array(
                    'profile_id' => $profile->getProfileId()
                ),
                \XLite::getAdminScript()
            )
        );

        static::register('url', $url);

        static::compose(
            static::TYPE_PROFILE_CREATED_ADMIN,
            static::getSiteAdministratorMail(),
            static::getUsersDepartmentMail(),
            'modules/XC/MultiVendor/vendor_signin_notification',
            array(),
            true,
            \XLite::CUSTOMER_INTERFACE,
            static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
        );
    }

    /**
     * Send notification about approved vendor profile to the user
     *
     * @param \XLite\Model\Profile $profile  Profile object
     *
     * @return void
     */
    public static function sendVendorApprovedNotification(\XLite\Model\Profile $profile)
    {
        // Register variables
        static::register('profile', $profile);

        $url = \XLite::getInstance()->getShopURL(
            \XLite\Core\Converter::buildURL('login', '', array(), \XLite::getAdminScript())
        );

        static::register('url', $url);

        // Compose and send email
        static::compose(
            static::TYPE_PROFILE_CREATED_USER,
            static::getSiteAdministratorMail(),
            $profile->getLogin(),
            'modules/XC/MultiVendor/vendor_approved_notification',
            array(),
            true,
            \XLite::CUSTOMER_INTERFACE,
            static::getMailer()->getLanguageCode(\XLite::CUSTOMER_INTERFACE, $profile->getLanguage())
        );
    }

    /**
     * Send notification about declined vendor profile to the user
     *
     * @param \XLite\Model\Profile $profile  Profile object
     *
     * @return void
     */
    public static function sendVendorDeclinedNotification(\XLite\Model\Profile $profile)
    {
        // Register variables
        static::register('profile', $profile);

        // Compose and send email
        static::compose(
            static::TYPE_PROFILE_CREATED_USER,
            static::getSiteAdministratorMail(),
            $profile->getLogin(),
            'modules/XC/MultiVendor/vendor_declined_notification',
            array(),
            true,
            \XLite::CUSTOMER_INTERFACE,
            static::getMailer()->getLanguageCode(\XLite::CUSTOMER_INTERFACE, $profile->getLanguage())
        );
    }

    // {{{ Order created

    /**
     * Send created order mails.
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderCreated(\XLite\Model\Order $order)
    {
        $isOrderShouldBeProcessed = \XLite\Module\XC\MultiVendor\Main::isWarehouseMode()
            ? (bool)$order->getOrderNumber()    // This is parent order in warehouse mode
            : (bool)$order->isChild();          // This is parent order in separate mode

        if ($isOrderShouldBeProcessed) {
            parent::sendOrderCreated($order);
        }
    }

    /**
     * Send created order mail to admin
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderCreatedAdmin(\XLite\Model\Order $order)
    {
        parent::sendOrderCreatedAdmin($order);

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                static::sendOrderCreatedVendor($child);
            }
        } else {
            static::sendOrderCreatedVendor($order);
        }
    }

    /**
     * Send created order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderCreatedVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_created' : 'modules/XC/MultiVendor/order_created',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is initially created (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    // {{{ Order processed

    /**
     * Send processed order mails
     *
     * @param \XLite\Model\Order $order                      Order model
     * @param boolean            $ignoreCustomerNotification Flag: do not send notification to customer OPTIONAL
     *
     * @return void
     */
    public static function sendOrderProcessed(\XLite\Model\Order $order, $ignoreCustomerNotification = false)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderProcessed($order, $ignoreCustomerNotification);
        }
    }

    /**
     * Send processed order mail to Admin
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderProcessedAdmin(\XLite\Model\Order $order)
    {
        parent::sendOrderProcessedAdmin($order);

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                static::sendOrderProcessedVendor($child);
            }
        } else {
            static::sendOrderProcessedVendor($order);
        }
    }

    /**
     * Send processed order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderProcessedVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_processed' : 'modules/XC/MultiVendor/order_processed',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is processed (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    // {{{ Order changed

    /**
     * Send changed order mails
     *
     * @param \XLite\Model\Order $order                      Order model
     * @param boolean            $ignoreCustomerNotification Flag: do not send notification to customer OPTIONAL
     *
     * @return void
     */
    public static function sendOrderChanged(\XLite\Model\Order $order, $ignoreCustomerNotification = false)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderChanged($order, $ignoreCustomerNotification);
        }
    }

    /**
     * Send changed order mail to Admin
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderChangedAdmin(\XLite\Model\Order $order)
    {
        parent::sendOrderChangedAdmin($order);

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                static::sendOrderChangedVendor($child);
            }
        } else {
            static::sendOrderChangedVendor($order);
        }
    }

    /**
     * Send changed order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderChangedVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_changed' : 'modules/XC/MultiVendor/order_changed',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is changed (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    // {{{ Order advanced changed (AOM)

    /**
     * Send changed order mail to Customer
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderAdvancedChangedCustomer(\XLite\Model\Order $order)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderAdvancedChangedCustomer($order);

            if ($order->isParent()) {
                foreach ($order->getChildren() as $child) {
                    static::sendOrderAdvancedChangedVendor($child);
                }
            } elseif (!Core\Auth::getInstance()->isVendor()) {
                static::sendOrderAdvancedChangedVendor($order);
            }
        }
    }

    /**
     * Send changed order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderAdvancedChangedVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_advanced_changed' : 'modules/XC/MultiVendor/order_advanced_changed',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is changed (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    /**
     * Send email notification about shipped order
     *
     * @param \XLite\Model\Order $order Order object
     *
     * @return void
     */
    public static function sendOrderShipped(\XLite\Model\Order $order)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderShipped($order);
        }
    }



    // {{{ Order failed

    /**
     * Send failed order mails
     *
     * @param \XLite\Model\Order $order                      Order model
     * @param boolean            $ignoreCustomerNotification Flag: do not send notification to customer OPTIONAL
     *
     * @return void
     */
    public static function sendOrderFailed(\XLite\Model\Order $order, $ignoreCustomerNotification = false)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderFailed($order, $ignoreCustomerNotification);
        }
    }

    /**
     * Send failed order mail to Admin
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderFailedAdmin(\XLite\Model\Order $order)
    {
        parent::sendOrderFailedAdmin($order);

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                static::sendOrderFailedVendor($child);
            }
        } else {
            static::sendOrderFailedVendor($order);
        }
    }

    /**
     * Send failed order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderFailedVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_failed' : 'modules/XC/MultiVendor/order_failed',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is failed (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    // {{{ Order canceled

    /**
     * Send canceled order mails
     *
     * @param \XLite\Model\Order $order                      Order model
     * @param boolean            $ignoreCustomerNotification Flag: do not send notification to customer OPTIONAL
     *
     * @return void
     */
    public static function sendOrderCanceled(\XLite\Model\Order $order, $ignoreCustomerNotification = false)
    {
        if ($order->getOrderNumber()) {
            parent::sendOrderCanceled($order, $ignoreCustomerNotification);
        }
    }

    /**
     * Send canceled order mail to Admin
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderCanceledAdmin(\XLite\Model\Order $order)
    {
        parent::sendOrderCanceledAdmin($order);

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                static::sendOrderCanceledVendor($child);
            }
        } else {
            static::sendOrderCanceledVendor($order);
        }
    }

    /**
     * Send canceled order mail to Vendor
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return void
     */
    public static function sendOrderCanceledVendor(\XLite\Model\Order $order)
    {
        /** @var \XLite\Model\Profile $vendor */
        $vendor = $order->getVendor();
        if ($vendor) {
            static::register('order', $order->getOrderNumber() ? $order : $order->getParent());
            static::register('displayForVendor', $vendor);

            $result = static::compose(
                static::TYPE_ORDER_PROCESSED_ADMIN,
                static::getOrdersDepartmentMail(),
                $vendor->getLogin(),
                $order->getOrderNumber() ? 'order_canceled' : 'modules/XC/MultiVendor/order_canceled',
                array(),
                true,
                \XLite::ADMIN_INTERFACE,
                static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
            );

            if ($result) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailSent(
                    $order->getOrderId(),
                    'Order is canceled (vendor)'
                );

            } elseif (static::$errorMessage) {
                \XLite\Core\OrderHistory::getInstance()->registerAdminEmailFailed(
                    $order->getOrderId(),
                    static::$errorMessage
                );
            }
        }
    }

    // }}}

    // {{{ Low limit warning

    /**
     * Send "Low limit warning" notification
     *
     * @param array $data Product data
     *
     * @return void
     */
    public static function sendLowLimitWarningAdmin($data)
    {
        if (isset($data['product']) && $data['product']->getVendor()) {
            static::sendLowLimitWarningVendor($data);

        } else {
            parent::sendLowLimitWarningAdmin($data);
        }
    }

    /**
     * Send "Low limit warning" notification to Vendor
     *
     * @param array $data Product data
     *
     * @return void
     */
    public static function sendLowLimitWarningVendor($data)
    {
        $product = $data['product'];
        $vendor = $product->getVendor();

        static::register('product', $data);

        static::compose(
            static::TYPE_LOW_LIMIT_WARNING,
            static::getOrdersDepartmentMail(),
            $vendor->getLogin(),
            'low_limit_warning',
            array(),
            true,
            \XLite::ADMIN_INTERFACE,
            static::getMailer()->getLanguageCode(\XLite::ADMIN_INTERFACE)
        );
    }

    // }}}
}
