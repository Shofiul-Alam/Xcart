<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

return function()
{
    $tablePrefix = \XLite::getInstance()->getOptions(array('database_details', 'table_prefix'));
    $table = $tablePrefix . 'config';

    $foreignKeys = \XLite\Core\Database::getEM()->getConnection()->getSchemaManager()->listTableForeignKeys($table);
    $index = null;

    foreach ($foreignKeys as $fk) {
        if (in_array('vendor_id', $fk->getLocalColumns())) {
            if ('CASCADE' != $fk->onDelete()) {
                $index = $fk->getName();
            }
            break;
        }
    }

    if ($index) {
        $query = 'ALTER TABLE ' . $table . ' DROP FOREIGN KEY ' . $index;
        \XLite\Core\Database::getEM()->getConnection()->executeQuery($query, array());
        \XLite\Core\Database::getEM()->clear();
    }

    $table = $tablePrefix . 'vendor';

    $foreignKeys = \XLite\Core\Database::getEM()->getConnection()->getSchemaManager()->listTableForeignKeys($table);
    $index = null;
    
    foreach ($foreignKeys as $fk) {
        if (in_array('product_id', $fk->getLocalColumns())) {
            $index = $fk->getName();
            break;
        }
    }

    if ($index) {
        $query = 'ALTER TABLE ' . $table . ' DROP FOREIGN KEY ' . $index;
        \XLite\Core\Database::getEM()->getConnection()->executeQuery($query, array());
        \XLite\Core\Database::getEM()->clear();
    }

    $columns = \XLite\Core\Database::getEM()->getConnection()->getSchemaManager()->listTableColumns($table);
    $index = null;

    foreach ($columns as $c) {
        if ('product_id' == $c->getName()) {
            $index = $c;
            break;
        }
    }

    if ($index) {
        $query = 'ALTER TABLE ' . $table . ' CHANGE product_id profile_id INT';
        \XLite\Core\Database::getEM()->getConnection()->executeQuery($query, array());
    }
};
