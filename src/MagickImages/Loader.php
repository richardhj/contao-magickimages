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

namespace MagickImages;

use MagickImages\Hook\IHook;


/**
 * Class Loader
 * Provide an ImageMagick based image resize function.
 *
 * @package MagickImages
 */
class Loader
{

    /**
     * @return IHook
     */
    static public function getInstance()
    {
        return $GLOBALS['container']['magickimages.hook'];
    }
}
