<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:588:"SELECT x0_.visible AS visible_0, x0_.id AS id_1, x0_.position AS position_2, x0_.decimals AS decimals_3, x0_.type AS type_4, x0_.addToNew AS addToNew_5, x0_.product_class_id AS product_class_id_6, x0_.attribute_group_id AS attribute_group_id_7, x0_.product_id AS product_id_8 FROM xc_attributes x0_ LEFT JOIN xc_attribute_translations x1_ ON x0_.id = x1_.id AND (x1_.code = ?) WHERE x0_.attribute_group_id IS NULL AND x0_.product_class_id IS NULL AND x0_.product_id IS NULL AND x0_.visible = ? AND x0_.type IN ('C', 'S') GROUP BY x0_.id ORDER BY x0_.position ASC, x0_.id ASC, x1_.name ASC";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":17:{s:7:"isMixed";b:0;s:8:"isSelect";b:1;s:8:"aliasMap";a:1:{s:1:"a";s:21:"XLite\Model\Attribute";}s:11:"relationMap";a:0:{}s:14:"parentAliasMap";a:0:{}s:13:"fieldMappings";a:6:{s:9:"visible_0";s:7:"visible";s:4:"id_1";s:2:"id";s:10:"position_2";s:8:"position";s:10:"decimals_3";s:8:"decimals";s:6:"type_4";s:4:"type";s:10:"addToNew_5";s:8:"addToNew";}s:14:"scalarMappings";a:0:{}s:12:"typeMappings";a:3:{s:18:"product_class_id_6";s:7:"integer";s:20:"attribute_group_id_7";s:7:"integer";s:12:"product_id_8";s:7:"integer";}s:14:"entityMappings";a:1:{s:1:"a";N;}s:12:"metaMappings";a:3:{s:18:"product_class_id_6";s:16:"product_class_id";s:20:"attribute_group_id_7";s:18:"attribute_group_id";s:12:"product_id_8";s:10:"product_id";}s:14:"columnOwnerMap";a:9:{s:9:"visible_0";s:1:"a";s:4:"id_1";s:1:"a";s:10:"position_2";s:1:"a";s:10:"decimals_3";s:1:"a";s:6:"type_4";s:1:"a";s:10:"addToNew_5";s:1:"a";s:18:"product_class_id_6";s:1:"a";s:20:"attribute_group_id_7";s:1:"a";s:12:"product_id_8";s:1:"a";}s:20:"discriminatorColumns";a:0:{}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:6:{s:9:"visible_0";s:21:"XLite\Model\Attribute";s:4:"id_1";s:21:"XLite\Model\Attribute";s:10:"position_2";s:21:"XLite\Model\Attribute";s:10:"decimals_3";s:21:"XLite\Model\Attribute";s:6:"type_4";s:21:"XLite\Model\Attribute";s:10:"addToNew_5";s:21:"XLite\Model\Attribute";}s:18:"isIdentifierColumn";a:0:{}s:17:"newObjectMappings";a:0:{}s:24:"metadataParameterMapping";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:2:{s:3:"lng";a:1:{i:0;i:0;}s:5:"state";a:1:{i:0;i:1;}}}