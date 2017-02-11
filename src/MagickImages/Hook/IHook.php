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


namespace MagickImages\Hook;

use MagickImages\Optimizer\IOptimizer;


/**
 * Interface IHook
 *
 * @package MagickImages
 */
interface IHook
{

	/**
	 * Set the image optimizer, used by the hook.
	 *
	 * @param IOptimizer $optimizer
	 */
	public function setOptimizer(IOptimizer $optimizer = null);


	/**
	 * Get the image optimizer, that is used by this hook.
	 *
	 * @return IOptimizer
	 */
	public function getOptimizer();


	/**
	 * Resize an image and store the resized version in the assets/images folder
	 *
	 * @param string  $image        The image path
	 * @param integer $width        The target width
	 * @param integer $height       The target height
	 * @param string  $mode         The resize mode
	 * @param string  $strCacheName The cached image path
	 * @param \File   $file         The image file object
	 * @param string  $strTarget    An optional target path
	 * @param \Image  $objImage     The image instance
	 *
	 * @return
	 */
	public function get($image, $width, $height, $mode, $strCacheName, \File $file, $strTarget, $objImage);


    /**
     * Fetch the image size array for a file. Contao handles this for plain images and svg images exclusively. This
     * function extends the functionality for psd, pdf and maybe even more file formats.
     *
     * @param \File|\MagickImages\File $file
     *
     * @return array
     */
    public function fetchImageSize($file);
}
