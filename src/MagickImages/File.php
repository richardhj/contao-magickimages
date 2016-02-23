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


/**
 * Class File
 *
 * This class overrides the contao core's class and reads from the Config's validImageTypes to check if a file is an
 * image. This is helpful if you want e.g. pdf files to be rendered as images (in the gallery module for example). You
 * simply have to set it in the config. Furthermore some adjustments for non-default image types like psd are made.
 *
 * @package MagickImages
 */
class File extends \Contao\File
{

	/**
	 * {@inheritdoc}
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'imageSize':
				// Check default routine first
				parent::__get($strKey);

				if ($this->isImage && empty($this->arrImageSize))
				{
					$this->arrImageSize = @getimagesize(TL_ROOT . '/' . $this->strFile); //@todo this helps for psd files. what's about a pdf file?
					# if we want to use a ImageMagick function: add a static getImageSize() to IHook
				}

				return $this->arrImageSize;
				break;

			case 'isImage':
				return in_array($this->extension, trimsplit(',', \Config::get('validImageTypes')));
				break;

			default:
				return parent::__get($strKey);
				break;
		}
	}
}
