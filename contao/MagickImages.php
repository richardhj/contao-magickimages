<?php

/**
 * MagickImages
 * ImageMagick integration for Contao Open Source CMS
 *
 * PHP Version 5.3
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    magickimages
 * @license    LGPL-3.0+
 * @link       http://avisota.org
 */


namespace MagickImages;


/**
 * Class MagickImages
 *
 * @package magickimages
 */
if ($GLOBALS['TL_CONFIG']['magickimages_process'])
{
	/**
	 * MagickImages Implementation using convert command with exec.
	 */
	abstract class MagickImagesImpl extends System {
		/**
		 * Resize an image
		 * 
		 * @param string $strImage
		 * @param mixed $varWidth
		 * @param mixed $varHeight
		 * @param string $strMode
		 * @param string $strCacheName
		 * @param File $objFile
		 */
		protected function resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
		{
			if (!$varWidth && !$varHeight) return false;
	
			// detect image format
			$strFormat = $objFile->extension;
			
			if (!(	$strFormat == 'jpg'
				||  $strFormat == 'png'
				||  $strFormat == 'gif'))
			{
				$strFormat = 'jpg';
			}
			
			// the target size
			$intWidth = intval($varWidth);
			$intHeight = intval($varHeight);
			
			// set the source path
			$strSource = TL_ROOT . '/' . $strImage;
			
			// set the output path
			$strTarget = TL_ROOT . '/' . $strCacheName;
			
			// begin build the exec command
			$arrCmd = array($strSource);
			
			// set the jpeg quality
			if ($strFormat=='jpg')
			{
				$arrCmd[] = '-quality';
				$arrCmd[] = $GLOBALS['TL_CONFIG']['jpgQuality'];
			}
			
			// add filter
			$arrCmd[] = '-filter';
			$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_filter'];
			
			// blur image
			if ($GLOBALS['TL_CONFIG']['magickimages_blur'])
			{
				$arrCmd[] = '-blur';
				$arrCmd[] = $GLOBALS['TL_CONFIG']['magickimages_blur_radius'] . 'x' . $GLOBALS['TL_CONFIG']['magickimages_blur_sigma'];
			}
			
			// unsharp image
			if ($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
			{
				$arrCmd[] = '-unsharp';
				$arrCmd[] = sprintf('%sx%s+%s+%s',
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'],
					$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
			}
			
			// Mode-specific changes
			if ($intWidth && $intHeight)
			{
				switch ($strMode)
				{
					case 'proportional':
						if ($objFile->width >= $objFile->height)
						{
							unset($varHeight, $intHeight);
						}
						else
						{
							unset($varWidth, $intWidth);
						}
						break;
	
					case 'box':
						if (ceil($objFile->height * $varWidth / $objFile->width) <= $intHeight)
						{
							unset($varHeight, $intHeight);
						}
						else
						{
							unset($varWidth, $intWidth);
						}
						break;
				}
			}

			// Resize width and height and crop the image if necessary
			if ($intWidth && $intHeight)
			{
				$dblSrcAspectRatio = $objFile->width / $objFile->height;
				$dblTargetAspectRatio = $intWidth / $intHeight;
				
				$arrCmd[] = '-resize';

				// Advanced crop modes
				switch ($strMode)
				{
					case 'left_top':
						$strGravity = 'NorthWest';
						break;

					case 'center_top':
						$strGravity = 'North';
						break;

					case 'right_top':
						$strGravity = 'NorthEast';
						break;

					case 'left_center':
						$strGravity = 'West';
						break;

					case 'right_center':
						$strGravity = 'East';
						break;

					case 'left_bottom':
						$strGravity = 'SouthWest';
						break;

					case 'center_bottom':
						$strGravity = 'South';
						break;

					case 'right_bottom':
						$strGravity = 'SouthEast';
						break;

					default:
						$strGravity = 'Center';
						break;
				}

				if ($dblSrcAspectRatio == $dblTargetAspectRatio)
				{
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
				else if ($dblSrcAspectRatio < $dblTargetAspectRatio)
				{
					$arrCmd[] = $intWidth . 'x' . $intHeight . '^';
					
					// crop image
					$arrCmd[] = '-gravity';
					$arrCmd[] = $strGravity;
					$arrCmd[] = '-extent';
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
				else if ($dblSrcAspectRatio > $dblTargetAspectRatio)
				{
					$arrCmd[] = '0x' . $intHeight . '^';
					
					// crop image
					$arrCmd[] = '-gravity';
					$arrCmd[] = $strGravity;
					$arrCmd[] = '-extent';
					$arrCmd[] = $intWidth . 'x' . $intHeight;
				}
			}
	
			// resize by width
			else if ($intWidth)
			{
				$arrCmd[] = '-resize';
				$arrCmd[] = $intWidth . 'x0^';
			}
	
			// resize by height
			else if ($intHeight)
			{
				$arrCmd[] = '-resize';
				$arrCmd[] = '0x' . $intHeight . '^';
			}
			
			// add target file path
			$arrCmd[] = $strTarget;
			
			// build command
			$strCmd = escapeshellcmd($GLOBALS['TL_CONFIG']['magickimages_convert_path']);
			foreach ($arrCmd as $strArg)
			{
				$strCmd .= ' ' . escapeshellarg($strArg);
			}
			
			if ($this->execute($strCmd)) {
				// Set the file permissions when the Safe Mode Hack is used
				if ($GLOBALS['TL_CONFIG']['useFTP'])
				{
					$this->import('Files');
					$this->Files->chmod($strCacheName, 0644);
				}

				// Return the path to new image
				return $strCacheName;
			}
			else {
				return false;
			}
		}
		
		protected abstract function execute($strCmd);
		
		protected abstract function optimize($strFile);
	}
}
else
{
	/**
	 * MagickImages Implementation using Imagick library.
	 */
	abstract class MagickImagesImpl extends System {
		/**
		 * Resize an image
		 * 
		 * @param string $strImage
		 * @param mixed $varWidth
		 * @param mixed $varHeight
		 * @param string $strMode
		 * @param string $strCacheName
		 * @param File $objFile
		 */
		protected function resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
		{
			if (!$varWidth && !$varHeight) return false;
	
			try {
				// detect image format
				$strFormat = $objFile->extension;
				
				if (!(	$strFormat == 'jpg'
					||  $strFormat == 'png'
					||  $strFormat == 'gif'))
				{
					$strFormat = 'jpg';
				}
				
				// the target size
				$intWidth = intval($varWidth);
				$intHeight = intval($varHeight);
				
				// load imagick
				$objImagick = new Imagick();
				
				// read the source file
				$objImagick->readImage(TL_ROOT . '/' . $strImage);
				
				// set the output format
				$objImagick->setImageFormat($strFormat);
				
				// set the jpeg quality
				if ($strFormat=='jpg')
				{
					$objImagick->setCompressionQuality($GLOBALS['TL_CONFIG']['jpgQuality']);
				}
				
				// set filter
				$strFilter = 'FILTER_' . strtoupper(preg_replace('#[^\w]#', '', $GLOBALS['TL_CONFIG']['magickimages_filter']));
				$intFilter = eval('return Imagick::'.$strFilter.';');
				
				// Mode-specific changes
				if ($intWidth && $intHeight)
				{
					switch ($strMode)
					{
						case 'proportional':
							if ($objFile->width >= $objFile->height)
							{
								unset($varHeight, $intHeight);
							}
							else
							{
								unset($varWidth, $intWidth);
							}
							break;
		
						case 'box':
							if (ceil($objFile->height * $varWidth / $objFile->width) <= $intHeight)
							{
								unset($varHeight, $intHeight);
							}
							else
							{
								unset($varWidth, $intWidth);
							}
							break;
					}
				}

				// Resize width and height and crop the image if necessary
				if ($intWidth && $intHeight)
				{
					$dblSrcAspectRatio = $objFile->width / $objFile->height;
					$dblTargetAspectRatio = $intWidth / $intHeight;

					// Advanced crop modes
					list($h, $v) = explode('_', $strMode);

					if ($dblSrcAspectRatio == $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							$intWidth,
							$intHeight,
							$intFilter,
							1);
					}
					else if ($dblSrcAspectRatio < $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							$intWidth,
							0,
							$intFilter,
							1);

						switch ($v) {
							case 'top':
								$intPositionY = 0;
								break;
							case 'bottom':
								$intPositionY = $objImagick->getImageHeight() - $intHeight;
								break;
							default:
								$intPositionY = ceil(($objImagick->getImageHeight() - $intHeight) / 2);
								break;
						}

						$objImagick->cropImage(
							$intWidth,
							$intHeight,
							0,
							$intPositionY);
					}
					else if ($dblSrcAspectRatio > $dblTargetAspectRatio)
					{
						$objImagick->resizeImage(
							0,
							$intHeight,
							$intFilter,
							1);

						switch ($h) {
							case 'left':
								$intPositionX = 0;
								break;
							case 'right':
								$intPositionX = $objImagick->getImageWidth() - $intWidth;
								break;
							default:
								$intPositionX = ceil(($objImagick->getImageWidth() - $intWidth) / 2);
								break;
						}

						$objImagick->cropImage(
							$intWidth,
							$intHeight,
							$intPositionX,
							0);
					}
				}
		
				// resize by width
				else if ($intWidth)
				{
					$objImagick->resizeImage(
						$intWidth,
						ceil($intWidth * $objFile->height / $objFile->width),
						$intFilter,
						1);
				}
		
				// resize by height
				else if ($intHeight)
				{
					$objImagick->resizeImage(
						ceil($intHeight * $objFile->width / $objFile->height),
						$intHeight,
						$intFilter,
						1);
				}

				// blur image
				if ($GLOBALS['TL_CONFIG']['magickimages_blur'])
				{
					$objImagick->blurimage($GLOBALS['TL_CONFIG']['magickimages_blur_radius'], $GLOBALS['TL_CONFIG']['magickimages_blur_sigma']);
				}
				
				// unsharp image
				if ($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
				{
					$objImagick->unsharpMaskImage(
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'],
						$GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);
				}
				
				if ($objImagick->writeImage(TL_ROOT . '/' . $strCacheName)) {
					// Set the file permissions when the Safe Mode Hack is used
					if ($GLOBALS['TL_CONFIG']['useFTP'])
					{
						$this->import('Files');
						$this->Files->chmod($strCacheName, 0644);
					}
					
					// Return the path to new image
					return $strCacheName;
				}
			} catch (ImagickException $e) {
				$this->log('Could not resize image "' . $strImage . '": '. $e->getMessage(), 'MagickImages::resize', TL_ERROR);
			}
			return false;
		}
		
		protected abstract function execute($strCmd);
		
		protected abstract function optimize($strFile);
	}
}

class MagickImages extends MagickImagesImpl {
	public function getImage($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile)
	{
		// break resize if ...
		if (
				// ImageMagick should not allways be used
				!$GLOBALS['TL_CONFIG']['magickimages_force']
				// and it is not necessary
			&& !(	$objFile->width  > $GLOBALS['TL_CONFIG']['gdMaxImgWidth']
				||  $objFile->height > $GLOBALS['TL_CONFIG']['gdMaxImgHeight']))
		{
			return false;
		}

		$strKey = '';

		// use pngrewrite on png's
		if (isset($GLOBALS['TL_CONFIG']['magickimages_pngrewrite']) &&
			$GLOBALS['TL_CONFIG']['magickimages_pngrewrite'] &&
			$objFile->extension == 'png') {
			$strKey .= 'R';
		}

		// use optipng
		if (isset($GLOBALS['TL_CONFIG']['magickimages_optipng']) &&
			$GLOBALS['TL_CONFIG']['magickimages_optipng'] &&
			in_array($objFile->extension, array('png', 'bmp', 'gif', 'pnm', 'tiff'))) {
			$strKey .= 'O';
		}

		// use optipng
		if (isset($GLOBALS['TL_CONFIG']['magickimages_advpng']) &&
			$GLOBALS['TL_CONFIG']['magickimages_advpng'] &&
			$objFile->extension == 'png') {
			$strKey .= 'A';
		}

		if (strlen($strKey)) {
			// this will break the contao caching mechanism!
			$strCacheName = preg_replace('#(\.\w+)$#', '-' . $strKey . '$1', $strCacheName);

			// Return the path of the new image if it exists already
			if (!$GLOBALS['TL_CONFIG']['debugMode'] && file_exists(TL_ROOT . '/' . $strCacheName))
			{
				return $strCacheName;
			}
		}

		// Hack to determinate the $target parameter of Controller::getImage
		$arrBacktrace = debug_backtrace();
		$arrCall = $arrBacktrace[1];
		if ($arrCall['class'] == 'Controller' && $arrCall['function'] == 'getImage' && isset($arrCall['args'][4]) && strlen($arrCall['args'][4]))
		{
			$strCacheName = $arrCall['args'][4];
		}
			
		$strImage = $this->resize($strImage, $varWidth, $varHeight, $strMode, $strCacheName, $objFile);

		if ($strImage) {
			// optimize image
			$this->optimize($strCacheName);

		}
		return $strImage;
	}
	
	protected function execute($strCmd)
	{
		switch ($GLOBALS['TL_CONFIG']['magickimages_process_call'])
		{
		case 'proc':
			// execute convert
			$procConvert = proc_open(
				$strCmd,
				array(
					0 => array("pipe", "r"),
					1 => array("pipe", "w"),
					2 => array("pipe", "w")
				),
				$arrPipes);
			if ($procConvert === false)
			{
				$this->log(sprintf("convert could not be started!
cmd: %s", $strCmd), 'MagickImages::getImage', TL_ERROR);
				return false;
			}
			// close stdin
			fclose($arrPipes[0]);
			// close stdout
			fclose($arrPipes[1]);
			// read and close stderr
			$strErr = stream_get_contents($arrPipes[2]);
			fclose($arrPipes[2]);
			// wait until yui-compressor terminates
			$intCode = proc_close($procConvert);
			if ($intCode != 0)
			{
				$this->log(sprintf("Execution of convert failed!
cmd: %s
stderr: %s", $strCmd, $strErr), 'MagickImages::getImage', TL_ERROR);
				return false;
			}
			break;
			
		case 'exec':
			exec($strCmd, $arrOutput, $varReturn);
			if ($varReturn != 0)
			{
				$this->log(sprintf("Execution of convert failed!
cmd: %s
output: %s", $strCmd, implode("\n", $arrOutput)), 'MagickImages::getImage', TL_ERROR);
				return false;
			}
			break;
			
		case 'shell_exec':
			$strOutput = shell_exec($strCmd);
			if ($strOutput)
			{
				$this->log(sprintf("Execution of convert failed!
cmd: %s
output: %s", $strCmd, $strOutput), 'MagickImages::getImage', TL_ERROR);
				return false;
			}
			break;
		}
		
		return true;
	}
		
	protected function optimize($strFile)
	{
		$objFile = new File($strFile);

		// use pngrewrite on png's
		if (isset($GLOBALS['TL_CONFIG']['magickimages_pngrewrite']) &&
			$GLOBALS['TL_CONFIG']['magickimages_pngrewrite'] &&
			$objFile->extension == 'png') {
			$strCmd = 'pngrewrite ' . escapeshellarg(TL_ROOT . '/' . $strFile) . ' ' . escapeshellarg(TL_ROOT . '/' . $strFile);
			$this->execute($strCmd);
		}

		// use optipng
		if (isset($GLOBALS['TL_CONFIG']['magickimages_optipng']) &&
			$GLOBALS['TL_CONFIG']['magickimages_optipng'] &&
			in_array($objFile->extension, array('png', 'bmp', 'gif', 'pnm', 'tiff'))) {
			$strCmd = 'optipng -o' . intval($GLOBALS['TL_CONFIG']['magickimages_optipng_optimization_level']) . ' ' . escapeshellarg(TL_ROOT . '/' . $strFile);
			$this->execute($strCmd);
		}

		// use optipng
		if (isset($GLOBALS['TL_CONFIG']['magickimages_advpng']) &&
			$GLOBALS['TL_CONFIG']['magickimages_advpng'] &&
			$objFile->extension == 'png') {
			$strCmd = 'advpng -z ';
			switch ($GLOBALS['TL_CONFIG']['magickimages_advpng_level']) {
				case 'store':
					$strCmd .= '--shrink-store';
					break;
				case 'fast':
					$strCmd .= '--shrink-fast';
					break;
				case 'extra':
					$strCmd .= '--shrink-extra';
					break;
				case 'insane':
					$strCmd .= '--shrink-insane';
					break;
				default:
					$strCmd .= '--shrink-normal';
					break;
			}
			$strCmd .= ' ' . escapeshellarg(TL_ROOT . '/' . $strFile);
			$this->execute($strCmd);
		}
	}
}