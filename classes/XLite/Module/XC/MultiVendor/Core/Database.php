<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * Database
 */
class Database extends \XLite\Core\Database implements \XLite\Base\IDecorator
{
    /**
     * loadClassMetadata event handler
     *
     * @param \Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs Event arguments
     *
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if ($classMetadata->table['name'] === 'products' && isset($classMetadata->table['uniqueConstraints'])) {
            $uc = $classMetadata->table['uniqueConstraints'];

            foreach ($uc as $name => $constraint) {
                if ($constraint['columns'] === array('sku')) {
                    $uc[$name]['columns'][] = 'vendor_id';
                }
            }

            $classMetadata->setPrimaryTable(array('uniqueConstraints' => $uc));
        }

        if ($classMetadata->table['name'] === 'config' && isset($classMetadata->table['uniqueConstraints'])) {
            $uc = $classMetadata->table['uniqueConstraints'];

            foreach ($uc as $name => $constraint) {
                if ($constraint['columns'] === array('name', 'category')) {
                    $uc[$name]['columns'][] = 'vendor_id';
                }
            }

            $classMetadata->setPrimaryTable(array('uniqueConstraints' => $uc));
        }

        parent::loadClassMetadata($eventArgs);
    }
}
