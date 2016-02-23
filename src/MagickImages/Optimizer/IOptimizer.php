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


namespace MagickImages\Optimizer;


/**
 * Interface IOptimizer
 *
 * @package MagickImages
 */
interface IOptimizer
{

	/**
	 * Optimize an image.
	 *
	 * @param string $strImage  The image path
	 * @param string $strTarget The target path, if its not set, use the $image path.
	 *
	 * @return string Return the optimized image path.
	 */
	public function optimize($strImage, $strTarget = null);
}
