<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:1692:"SELECT x0_.socialLoginProvider AS socialLoginProvider_0, x0_.socialLoginId AS socialLoginId_1, x0_.gaClientId AS gaClientId_2, x0_.pictureUrl AS pictureUrl_3, x0_.default_card_id AS default_card_id_4, x0_.pending_zero_auth AS pending_zero_auth_5, x0_.pending_zero_auth_txn_id AS pending_zero_auth_txn_id_6, x0_.pending_zero_auth_status AS pending_zero_auth_status_7, x0_.pending_zero_auth_interface AS pending_zero_auth_interface_8, x0_.profile_id AS profile_id_9, x0_.login AS login_10, x0_.password AS password_11, x0_.password_hint AS password_hint_12, x0_.password_hint_answer AS password_hint_answer_13, x0_.passwordResetKey AS passwordResetKey_14, x0_.passwordResetKeyDate AS passwordResetKeyDate_15, x0_.access_level AS access_level_16, x0_.cms_profile_id AS cms_profile_id_17, x0_.cms_name AS cms_name_18, x0_.added AS added_19, x0_.first_login AS first_login_20, x0_.last_login AS last_login_21, x0_.status AS status_22, x0_.statusComment AS statusComment_23, x0_.referer AS referer_24, x0_.language AS language_25, x0_.last_shipping_id AS last_shipping_id_26, x0_.last_payment_id AS last_payment_id_27, x0_.anonymous AS anonymous_28, x0_.forceChangePassword AS forceChangePassword_29, x0_.dateOfLoginAttempt AS dateOfLoginAttempt_30, x0_.countOfLoginAttempts AS countOfLoginAttempts_31, x0_.searchFakeField AS searchFakeField_32, x0_.xcPendingExport AS xcPendingExport_33, x0_.order_id AS order_id_34, x0_.membership_id AS membership_id_35, x0_.pending_membership_id AS pending_membership_id_36 FROM xc_profiles x0_ LEFT JOIN xc_profile_addresses x1_ ON x0_.profile_id = x1_.profile_id WHERE (x0_.order_id IS NULL AND x0_.anonymous <> ?) AND x0_.login = ? AND x0_.status = ? LIMIT 1";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":17:{s:7:"isMixed";b:0;s:8:"isSelect";b:1;s:8:"aliasMap";a:1:{s:1:"p";s:19:"XLite\Model\Profile";}s:11:"relationMap";a:0:{}s:14:"parentAliasMap";a:0:{}s:13:"fieldMappings";a:34:{s:21:"socialLoginProvider_0";s:19:"socialLoginProvider";s:15:"socialLoginId_1";s:13:"socialLoginId";s:12:"gaClientId_2";s:10:"gaClientId";s:12:"pictureUrl_3";s:10:"pictureUrl";s:17:"default_card_id_4";s:15:"default_card_id";s:19:"pending_zero_auth_5";s:17:"pending_zero_auth";s:26:"pending_zero_auth_txn_id_6";s:24:"pending_zero_auth_txn_id";s:26:"pending_zero_auth_status_7";s:24:"pending_zero_auth_status";s:29:"pending_zero_auth_interface_8";s:27:"pending_zero_auth_interface";s:12:"profile_id_9";s:10:"profile_id";s:8:"login_10";s:5:"login";s:11:"password_11";s:8:"password";s:16:"password_hint_12";s:13:"password_hint";s:23:"password_hint_answer_13";s:20:"password_hint_answer";s:19:"passwordResetKey_14";s:16:"passwordResetKey";s:23:"passwordResetKeyDate_15";s:20:"passwordResetKeyDate";s:15:"access_level_16";s:12:"access_level";s:17:"cms_profile_id_17";s:14:"cms_profile_id";s:11:"cms_name_18";s:8:"cms_name";s:8:"added_19";s:5:"added";s:14:"first_login_20";s:11:"first_login";s:13:"last_login_21";s:10:"last_login";s:9:"status_22";s:6:"status";s:16:"statusComment_23";s:13:"statusComment";s:10:"referer_24";s:7:"referer";s:11:"language_25";s:8:"language";s:19:"last_shipping_id_26";s:16:"last_shipping_id";s:18:"last_payment_id_27";s:15:"last_payment_id";s:12:"anonymous_28";s:9:"anonymous";s:22:"forceChangePassword_29";s:19:"forceChangePassword";s:21:"dateOfLoginAttempt_30";s:18:"dateOfLoginAttempt";s:23:"countOfLoginAttempts_31";s:20:"countOfLoginAttempts";s:18:"searchFakeField_32";s:15:"searchFakeField";s:18:"xcPendingExport_33";s:15:"xcPendingExport";}s:14:"scalarMappings";a:0:{}s:12:"typeMappings";a:3:{s:11:"order_id_34";s:7:"integer";s:16:"membership_id_35";s:7:"integer";s:24:"pending_membership_id_36";s:7:"integer";}s:14:"entityMappings";a:1:{s:1:"p";N;}s:12:"metaMappings";a:3:{s:11:"order_id_34";s:8:"order_id";s:16:"membership_id_35";s:13:"membership_id";s:24:"pending_membership_id_36";s:21:"pending_membership_id";}s:14:"columnOwnerMap";a:37:{s:21:"socialLoginProvider_0";s:1:"p";s:15:"socialLoginId_1";s:1:"p";s:12:"gaClientId_2";s:1:"p";s:12:"pictureUrl_3";s:1:"p";s:17:"default_card_id_4";s:1:"p";s:19:"pending_zero_auth_5";s:1:"p";s:26:"pending_zero_auth_txn_id_6";s:1:"p";s:26:"pending_zero_auth_status_7";s:1:"p";s:29:"pending_zero_auth_interface_8";s:1:"p";s:12:"profile_id_9";s:1:"p";s:8:"login_10";s:1:"p";s:11:"password_11";s:1:"p";s:16:"password_hint_12";s:1:"p";s:23:"password_hint_answer_13";s:1:"p";s:19:"passwordResetKey_14";s:1:"p";s:23:"passwordResetKeyDate_15";s:1:"p";s:15:"access_level_16";s:1:"p";s:17:"cms_profile_id_17";s:1:"p";s:11:"cms_name_18";s:1:"p";s:8:"added_19";s:1:"p";s:14:"first_login_20";s:1:"p";s:13:"last_login_21";s:1:"p";s:9:"status_22";s:1:"p";s:16:"statusComment_23";s:1:"p";s:10:"referer_24";s:1:"p";s:11:"language_25";s:1:"p";s:19:"last_shipping_id_26";s:1:"p";s:18:"last_payment_id_27";s:1:"p";s:12:"anonymous_28";s:1:"p";s:22:"forceChangePassword_29";s:1:"p";s:21:"dateOfLoginAttempt_30";s:1:"p";s:23:"countOfLoginAttempts_31";s:1:"p";s:18:"searchFakeField_32";s:1:"p";s:18:"xcPendingExport_33";s:1:"p";s:11:"order_id_34";s:1:"p";s:16:"membership_id_35";s:1:"p";s:24:"pending_membership_id_36";s:1:"p";}s:20:"discriminatorColumns";a:0:{}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:34:{s:21:"socialLoginProvider_0";s:19:"XLite\Model\Profile";s:15:"socialLoginId_1";s:19:"XLite\Model\Profile";s:12:"gaClientId_2";s:19:"XLite\Model\Profile";s:12:"pictureUrl_3";s:19:"XLite\Model\Profile";s:17:"default_card_id_4";s:19:"XLite\Model\Profile";s:19:"pending_zero_auth_5";s:19:"XLite\Model\Profile";s:26:"pending_zero_auth_txn_id_6";s:19:"XLite\Model\Profile";s:26:"pending_zero_auth_status_7";s:19:"XLite\Model\Profile";s:29:"pending_zero_auth_interface_8";s:19:"XLite\Model\Profile";s:12:"profile_id_9";s:19:"XLite\Model\Profile";s:8:"login_10";s:19:"XLite\Model\Profile";s:11:"password_11";s:19:"XLite\Model\Profile";s:16:"password_hint_12";s:19:"XLite\Model\Profile";s:23:"password_hint_answer_13";s:19:"XLite\Model\Profile";s:19:"passwordResetKey_14";s:19:"XLite\Model\Profile";s:23:"passwordResetKeyDate_15";s:19:"XLite\Model\Profile";s:15:"access_level_16";s:19:"XLite\Model\Profile";s:17:"cms_profile_id_17";s:19:"XLite\Model\Profile";s:11:"cms_name_18";s:19:"XLite\Model\Profile";s:8:"added_19";s:19:"XLite\Model\Profile";s:14:"first_login_20";s:19:"XLite\Model\Profile";s:13:"last_login_21";s:19:"XLite\Model\Profile";s:9:"status_22";s:19:"XLite\Model\Profile";s:16:"statusComment_23";s:19:"XLite\Model\Profile";s:10:"referer_24";s:19:"XLite\Model\Profile";s:11:"language_25";s:19:"XLite\Model\Profile";s:19:"last_shipping_id_26";s:19:"XLite\Model\Profile";s:18:"last_payment_id_27";s:19:"XLite\Model\Profile";s:12:"anonymous_28";s:19:"XLite\Model\Profile";s:22:"forceChangePassword_29";s:19:"XLite\Model\Profile";s:21:"dateOfLoginAttempt_30";s:19:"XLite\Model\Profile";s:23:"countOfLoginAttempts_31";s:19:"XLite\Model\Profile";s:18:"searchFakeField_32";s:19:"XLite\Model\Profile";s:18:"xcPendingExport_33";s:19:"XLite\Model\Profile";}s:18:"isIdentifierColumn";a:0:{}s:17:"newObjectMappings";a:0:{}s:24:"metadataParameterMapping";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:3:{s:9:"anonymous";a:1:{i:0;i:0;}s:7:"p_login";a:1:{i:0;i:1;}s:8:"p_status";a:1:{i:0;i:2;}}}