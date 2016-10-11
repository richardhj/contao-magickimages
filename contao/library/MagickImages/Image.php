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


namespace MagickImages;

use MagickImages\Model\Config as MagickImagesConfig;


/**
 * Class Image
 *
 * This class overrides the contao core's class and adjusts the cache name's file extension. This is necessary to
 * convert nonstandard extensions like psd and pdf to a fallback extension like jpg or png. We have to do it here
 * because a resized image will not be loaded from assets cache otherwise.
 *
 * @package MagickImages
 */
class Image extends \Contao\Image
{

	/**
	 * {@inheritdoc}
	 */
	public function getCacheName()
	{
        $strFallbackFormat = MagickImagesConfig::getInstance()->fallback_extension ?: 'jpg';

		if (!in_array($this->fileObj->extension, ['jpg', 'png', 'gif']))
		{
			// Change file suffix
			return substr(parent::getCacheName(), 0, -strlen($this->fileObj->extension)) . $strFallbackFormat;
		}

		return parent::getCacheName();
	}
}
