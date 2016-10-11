<?php
/**
 * E-POSTBUSINESS API integration for Contao Open Source CMS
 *
 * Copyright (c) 2015-2016 Richard Henkenjohann
 *
 * @package E-POST
 * @author  Richard Henkenjohann <richard-epost@henkenjohann.me>
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
