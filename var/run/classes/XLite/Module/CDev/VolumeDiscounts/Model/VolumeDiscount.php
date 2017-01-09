<?php
namespace XLite\Module\CDev\VolumeDiscounts\Model;
/**
 * Volume discount model
 *
 * @Entity
 * @Table  (name="volume_discounts",
 *      indexes={
 *          @Index (name="range", columns={"subtotalRangeBegin", "subtotalRangeEnd"})
 *      }
 * )
 */
class VolumeDiscount extends \XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\Model\VolumeDiscount {}