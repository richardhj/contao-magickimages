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

use MagickImages\Hook\IHook;


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
				global $container;

				// Process default routine first
                $this->arrImageSize = parent::__get($strKey);

                if (!empty($this->arrImageSize)) {
                    return $this->arrImageSize;
                }

				/** @var IHook $hook */
				$hook = $container['magickimages.hook'];
				$this->arrImageSize = $hook->fetchImageSize($this);

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
