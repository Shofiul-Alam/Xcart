<?php
namespace XLite\Model;
/**
 * DB-based configuration registry
 *
 * @Entity
 * @Table  (name="config",
 *      uniqueConstraints={
 *          @UniqueConstraint (name="nc", columns={"name", "category"})
 *      },
 *      indexes={
 *          @Index (name="orderby", columns={"orderby"}),
 *          @Index (name="type", columns={"type"})
 *      }
 * )
 */
class Config extends \XLite\Module\XC\MultiVendor\Model\Config {}