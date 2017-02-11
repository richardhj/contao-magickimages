<?php

/**
 * MagickImages
 * ImageMagick integration for Contao Open Source CMS
 *
 * PHP Version 5.3
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @author     Richard Henkenjohann 2016
 * @package    MagickImages
 * @license    LGPL-3.0+
 */


/**
 * Implementations
 */
$GLOBALS['MAGICKIMAGES_IMPLEMENTATIONS'][] = 'process';
$GLOBALS['MAGICKIMAGES_IMPLEMENTATIONS'][] = 'imagick';

/**
 * global settings
 */
$GLOBALS['TL_CONFIG']['magickimages_force']                  = false;
$GLOBALS['TL_CONFIG']['magickimages_implementation']         = class_exists('Imagick', false) ? 'imagick' : 'process';
$GLOBALS['TL_CONFIG']['magickimages_convert_path']           = 'convert';
$GLOBALS['TL_CONFIG']['magickimages_filter']                 = 'Cubic';
$GLOBALS['TL_CONFIG']['magickimages_blur']                   = false;
$GLOBALS['TL_CONFIG']['magickimages_blur_radius']            = 3;
$GLOBALS['TL_CONFIG']['magickimages_blur_sigma']             = 2;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask']           = false;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius']    = 1.5;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma']     = 1.2;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount']    = 1;
$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold'] = 0.1;

/**
 * pngrewrite optimizer settings
 */
$GLOBALS['TL_CONFIG']['magickimages_pngrewrite_path'] = 'pngrewrite';

/**
 * optipng optimizer settings
 */
$GLOBALS['TL_CONFIG']['magickimages_optipng_path']               = 'optipng';
$GLOBALS['TL_CONFIG']['magickimages_optipng_optimization_level'] = 2;

/**
 * advpng optimizer settings
 */
$GLOBALS['TL_CONFIG']['magickimages_advpng_path']  = 'advpng';
$GLOBALS['TL_CONFIG']['magickimages_advpng_level'] = 'normal';

/**
 * Overall activated optimizers
 */
$GLOBALS['TL_CONFIG']['magickimages_optimizers'] = array_reduce(
    ['pngrewrite', 'optipng', 'advpng'],
    function ($carry, $item) {
        if ($GLOBALS['TL_CONFIG']['magickimages_'.$item]) {
            $carry[] = $item;
        }

        return $carry;
    },
    []
);

/**
 * HOOKS
 */
$GLOBALS['TL_HOOKS']['getImage'][] = ['MagickImages\Loader', 'get'];
