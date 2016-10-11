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


$table = MagickImages\Model\Config::getTable();
$this->loadLanguageFile('magickimages_implementation');


$GLOBALS['TL_DCA'][$table] = [

    // Config
    'config' => [
        'dataContainer' => 'General',
        'forceEdit'     => true,
    ],

    'dca_config'      => [
        'data_provider' => [
            'default' => [
                'class' => 'DcGeneral\Data\SingleModelDataProvider',
            ],
        ],
        'view'          => 'DcGeneral\Contao\View\Contao2BackendView\SingleModelView',
    ],

    // MetaPalettes
    'metapalettes'    => [
        'default' => [
            'config' => [
                'force',
                'implementation',
                'filter',
                'fallback_extension',
                'blur',
                'unsharp_mask',
                'pngrewrite',
                'optipng',
                'advpng',
            ],
        ],
    ],

    // MetaSubPalettes
    'metasubpalettes' => [
        'implementation_process' => [
            'convert_path',
        ],
        'blur'                   => [
            'blur_radius',
            'blur_sigma',
        ],
        'unsharp_mask'           => [
            'unsharp_mask_radius',
            'unsharp_mask_sigma',
            'unsharp_mask_amount',
            'unsharp_mask_threshold',
        ],
        'optipng'                => [
            'optipng_optimization_level',
        ],
        'advpng'                 => [
            'advpng_level',
        ],
    ],

    // Fields
    'fields'          => [
        'force'                      => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['force'],
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50 m12 clr'],
        ],
        'implementation'             => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['implementation'],
            'inputType' => 'select',
            'options'   => $GLOBALS['IMPLEMENTATIONS'],
            'reference' => &$GLOBALS['TL_LANG']['implementation'],
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        ],
        'convert_path'               => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['convert_path'],
            'inputType' => 'text',
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50'],
        ],
        'filter'                     => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['filter'],
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
            'eval'      => ['tl_class' => 'clr'],
        ],
        'fallback_extension'         => [
            'label'         => &$GLOBALS['TL_LANG'][$table]['fallback_extension'],
            'inputType'     => 'text',
            'eval'          => [
                'tl_class' => 'w50',
            ],
            'save_callback' => [['MagickImages\Helper\Dca', 'checkValidFallbackExtension']],
        ],
        'blur'                       => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['blur'],
            'inputType' => 'checkbox',
            'eval'      => [
                'tl_class'       => 'w50 m12 clr',
                'submitOnChange' => true,
            ],
        ],
        'blur_radius'                => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['blur_radius'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'      => 'digit',
                'mandatory' => true,
                'tl_class'  => 'w50 clr',
            ],
        ],
        'blur_sigma'                 => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['blur_sigma'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50',
            ],
        ],
        'unsharp_mask'               => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['unsharp_mask'],
            'inputType' => 'checkbox',
            'eval'      => [
                'tl_class'       => 'w50 m12 clr',
                'submitOnChange' => true,
            ],
        ],
        'unsharp_mask_radius'        => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['unsharp_mask_radius'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50 clr',
            ],
        ],
        'unsharp_mask_sigma'         => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['unsharp_mask_sigma'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50',
            ],
        ],
        'unsharp_mask_amount'        => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['unsharp_mask_amount'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50',
            ],
        ],
        'unsharp_mask_threshold'     => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['unsharp_mask_threshold'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50',
            ],
        ],
        'pngrewrite'                 => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['pngrewrite'],
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'm12 w50 clr'],
        ],
        'optipng'                    => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['optipng'],
            'inputType' => 'checkbox',
            'eval'      => [
                'submitOnChange' => true,
                'tl_class'       => 'm12 w50 clr',
            ],
        ],
        'optipng_optimization_level' => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['optipng_optimization_level'],
            'inputType' => 'select',
            'options'   => [0, 1, 2, 3, 4, 5, 6, 7],
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
        ],
        'advpng'                     => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['advpng'],
            'inputType' => 'checkbox',
            'eval'      => [
                'submitOnChange' => true,
                'tl_class'       => 'm12 w50 clr',
            ],
        ],
        'advpng_level'               => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['advpng_level'],
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
        ],
    ],
];
