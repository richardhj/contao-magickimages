<?php

/**
 * MagickImages
 * ImageMagick integration for Contao Open Source CMS
 *
 * PHP Version 5.3
 *
 * @author     Richard Henkenjohann 2016
 * @package    MagickImages
 * @license    LGPL-3.0+
 */

namespace MagickImages\Model;

use DcGeneral\Contao\Model\AbstractSingleModel;


/**
 * Class Config
 * @property string $implemantation
 * @property string $fallback_extension
 * @property        $advpng_level
 * @property        $advpng_path
 * @property        $optipng_path
 * @property        $optipng_optimization_level
 * @property        $pngrewrite_path
 * @property        $convert_path
 * @property        $filter
 * @property        $blur
 * @property        $blur_radius
 * @property        $blur_sigma
 * @property        $unsharp_mask
 * @property        $unsharp_mask_radius
 * @property        $unsharp_mask_sigma
 * @property        $unsharp_mask_amount
 * @property        $unsharp_mask_threshold
 * @package MagickImages\Model
 */
class Config extends AbstractSingleModel
{

    /**
     * {@inheritdoc}
     */
    protected static $strTable = 'tl_magickimages_config';


    /**
     * {@inheritdoc}
     */
    protected static $objInstance;
}
