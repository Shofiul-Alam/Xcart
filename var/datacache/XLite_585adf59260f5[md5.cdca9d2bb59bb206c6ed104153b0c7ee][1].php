<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:474:"SELECT x0_.id AS id_0, x0_.product_class_id AS sclr_1, x1_.name AS name_2, x2_.name AS name_3, x0_.visible AS visible_4 FROM xc_attribute_values_select x3_ INNER JOIN xc_attributes x0_ ON x3_.attribute_id = x0_.id LEFT JOIN xc_attribute_options x4_ ON x3_.attribute_option_id = x4_.id INNER JOIN xc_attribute_translations x1_ ON x0_.id = x1_.id AND (x1_.code = ?) INNER JOIN xc_attribute_option_translations x2_ ON x4_.id = x2_.id AND (x2_.code = ?) WHERE x3_.product_id = ?";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":17:{s:7:"isMixed";b:0;s:8:"isSelect";b:1;s:8:"aliasMap";a:0:{}s:11:"relationMap";a:0:{}s:14:"parentAliasMap";a:0:{}s:13:"fieldMappings";a:0:{}s:14:"scalarMappings";a:5:{s:4:"id_0";s:2:"id";s:6:"sclr_1";s:14:"productClassId";s:6:"name_2";s:4:"name";s:6:"name_3";s:5:"value";s:9:"visible_4";s:7:"visible";}s:12:"typeMappings";a:5:{s:4:"id_0";s:7:"integer";s:6:"sclr_1";s:6:"string";s:6:"name_2";s:6:"string";s:6:"name_3";s:6:"string";s:9:"visible_4";s:7:"boolean";}s:14:"entityMappings";a:0:{}s:12:"metaMappings";a:0:{}s:14:"columnOwnerMap";a:0:{}s:20:"discriminatorColumns";a:0:{}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:0:{}s:18:"isIdentifierColumn";a:0:{}s:17:"newObjectMappings";a:0:{}s:24:"metadataParameterMapping";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:2:{s:6:"lng_en";a:2:{i:0;i:0;i:1;i:1;}s:9:"productId";a:1:{i:0;i:2;}}}