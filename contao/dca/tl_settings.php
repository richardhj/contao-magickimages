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


$this->loadLanguageFile('magickimages_implementation');

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_implementation';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_blur';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_unsharp_mask';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_optipng';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'magickimages_advpng';

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{magickimages_legend:hide},magickimages_force,magickimages_implementation,magickimages_filter,magickimages_fallback_extension,magickimages_blur,magickimages_unsharp_mask,magickimages_pngrewrite,magickimages_optipng,magickimages_advpng';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_implementation_process'] = 'magickimages_convert_path';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_blur']                   = 'magickimages_blur_radius,magickimages_blur_sigma';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_unsharp_mask']           = 'magickimages_unsharp_mask_radius,magickimages_unsharp_mask_sigma,magickimages_unsharp_mask_amount,magickimages_unsharp_mask_threshold';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_optipng']                = 'magickimages_optipng_optimization_level';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['magickimages_advpng']                 = 'magickimages_advpng_level';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_force'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_force'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'w50 m12 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_implementation'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_implementation'],
    'inputType' => 'select',
    'options'   => $GLOBALS['MAGICKIMAGES_IMPLEMENTATIONS'],
    'reference' => &$GLOBALS['TL_LANG']['magickimages_implementation'],
    'eval'      => [
        'submitOnChange' => true,
        'tl_class'       => 'w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_convert_path'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_convert_path'],
    'inputType' => 'text',
    'eval'      => [
        'submitOnChange' => true,
        'tl_class'       => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_filter'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_filter'],
    'inputType' => 'select',
    'options'   => [
        'Box',
        'Catrom',
        'Cubic',
        'Gaussian',
        'Hermite',
        'Mitchell',
        'Point',
        'Quadratic',
        'Triangle',
    ],
    'eval'      => [
        'tl_class' => 'clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_fallback_extension'] = [
    'label'         => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_fallback_extension'],
    'inputType'     => 'text',
    'eval'          => [
        'tl_class' => 'w50',
    ],
    'save_callback' => [
        ['MagickImages\Helper\Dca', 'checkValidFallbackExtension'],
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class'       => 'w50 m12 clr',
        'submitOnChange' => true,
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur_radius'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_radius'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'      => 'digit',
        'mandatory' => true,
        'tl_class'  => 'w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_blur_sigma'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_blur_sigma'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'     => 'digit',
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class'       => 'w50 m12 clr',
        'submitOnChange' => true,
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_radius'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_radius'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'     => 'digit',
        'tl_class' => 'w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_sigma'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_sigma'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'     => 'digit',
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_amount'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_amount'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'     => 'digit',
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_unsharp_mask_threshold'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_unsharp_mask_threshold'],
    'inputType' => 'text',
    'eval'      => [
        'rgxp'     => 'digit',
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_pngrewrite'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_pngrewrite'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'm12 w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_optipng'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng'],
    'inputType' => 'checkbox',
    'eval'      => [
        'submitOnChange' => true,
        'tl_class'       => 'm12 w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_optipng_optimization_level'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_optipng_optimization_level'],
    'inputType' => 'select',
    'options'   => [
        0,
        1,
        2,
        3,
        4,
        5,
        6,
        7,
    ],
    'reference' => [
        0 => '0 (fast)',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5 (slow)',
        6 => '6',
        7 => '7 (very slow)',
    ],
    'eval'      => [
        'tl_class'      => 'w50',
        'isAssociative' => true,
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_advpng'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng'],
    'inputType' => 'checkbox',
    'eval'      => [
        'submitOnChange' => true,
        'tl_class'       => 'm12 w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['magickimages_advpng_level'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['magickimages_advpng_level'],
    'inputType' => 'select',
    'options'   => [
        'store'  => 'don\'t compress',
        'fast'   => 'compress fast',
        'normal' => 'compress normal',
        'extra'  => 'compress extra',
        'insane' => 'compress extreme',
    ],
    'eval'      => [
        'tl_class'      => 'w50',
        'isAssociative' => true,
    ],
];
