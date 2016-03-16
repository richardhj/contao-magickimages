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


namespace MagickImages\Helper;


class Dca
{
	/**
	 * Check for valid fallback extension and convert lowercase
	 * @category save_callback
	 *
	 * @param mixed $varValue
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function checkValidFallbackExtension($varValue)
	{
		$varValue = strtolower($varValue);

		if (!in_array($varValue, ['jpg', 'png', 'gif']))
		{
			throw new \Exception('Extension is not allowed.');
		}

		return $varValue;
	}
}
