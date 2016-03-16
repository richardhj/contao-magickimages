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


namespace MagickImages\Hook\Implementation;

use MagickImages\Hook\IHook;
use MagickImages\Optimizer\IOptimizer;
use Symfony\Component\Process\ProcessBuilder;


/**
 * Class Process
 *
 * @package MagickImages
 */
class Process implements IHook
{

	/**
	 * @var IOptimizer
	 */
	protected $objOptimizer;


	/**
	 * @var string
	 */
	protected $strPath = 'convert';


	/**
	 * @var float
	 */
	protected $fltJpegQuality;


	/**
	 * @var bool
	 */
	protected $blnSmhEnabled;


	/**
	 * @var string
	 */
	protected $strFilter;


	/**
	 * @var bool
	 */
	protected $blnBlurEnabled;


	/**
	 * @var float
	 */
	protected $fltBlurRadius;


	/**
	 * @var float
	 */
	protected $fltBlurSigma;


	/**
	 * @var bool
	 */
	protected $blnUnsharpMaskEnabled;


	/**
	 * @var float
	 */
	protected $fltUnsharpMaskRadius;


	/**
	 * @var float
	 */
	protected $fltUnsharpMaskSigma;


	/**
	 * @var float
	 */
	protected $fltUnsharpMaskAmount;


	/**
	 * @var float
	 */
	protected $fltUnsharpMaskThreshold;


	/**
	 * @param string $strPath
	 *
	 * @return $this
	 */
	public function setPath($strPath)
	{
		$this->strPath = $strPath;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->strPath;
	}


	/**
	 * {@inheritdoc}
	 */
	public function setOptimizer(IOptimizer $objOptimizer = null)
	{
		$this->objOptimizer = $objOptimizer;

		return $this;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getOptimizer()
	{
		return $this->objOptimizer;
	}


	/**
	 * @param float $fltJpegQuality
	 *
	 * @return $this
	 */
	public function setJpegQuality($fltJpegQuality)
	{
		$this->fltJpegQuality = $fltJpegQuality;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getJpegQuality()
	{
		return $this->fltJpegQuality;
	}


	/**
	 * @param boolean $blnSmhEnabled
	 *
	 * @return $this
	 */
	public function setSmhEnabled($blnSmhEnabled)
	{
		$this->blnSmhEnabled = (bool)$blnSmhEnabled;

		return $this;
	}


	/**
	 * @return boolean
	 */
	public function isSmhEnabled()
	{
		return $this->blnSmhEnabled;
	}


	/**
	 * @param string $strFilter
	 *
	 * @return $this
	 */
	public function setFilter($strFilter)
	{
		$this->strFilter = $strFilter;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getFilter()
	{
		return $this->strFilter;
	}


	/**
	 * @param boolean $blnBlurEnabled
	 *
	 * @return $this
	 */
	public function setBlurEnabled($blnBlurEnabled)
	{
		$this->blnBlurEnabled = (bool)$blnBlurEnabled;

		return $this;
	}


	/**
	 * @return boolean
	 */
	public function isBlur()
	{
		return $this->blnBlurEnabled;
	}


	/**
	 * @param float $fltBlurRadius
	 *
	 * @return $this
	 */
	public function setBlurRadius($fltBlurRadius)
	{
		$this->fltBlurRadius = $fltBlurRadius;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getBlurRadius()
	{
		return $this->fltBlurRadius;
	}


	/**
	 * @param float $fltBlurSigma
	 *
	 * @return $this
	 */
	public function setBlurSigma($fltBlurSigma)
	{
		$this->fltBlurSigma = $fltBlurSigma;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getBlurSigma()
	{
		return $this->fltBlurSigma;
	}


	/**
	 * @param boolean $blnUnsharpMaskEnabled
	 *
	 * @return $this
	 */
	public function setUnsharpMaskEnabled($blnUnsharpMaskEnabled)
	{
		$this->blnUnsharpMaskEnabled = (bool)$blnUnsharpMaskEnabled;

		return $this;
	}


	/**
	 * @return boolean
	 */
	public function isUnsharpMask()
	{
		return $this->blnUnsharpMaskEnabled;
	}


	/**
	 * @param float $fltUnsharpMaskRadius
	 *
	 * @return $this
	 */
	public function setUnsharpMaskRadius($fltUnsharpMaskRadius)
	{
		$this->fltUnsharpMaskRadius = $fltUnsharpMaskRadius;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getUnsharpMaskRadius()
	{
		return $this->fltUnsharpMaskRadius;
	}


	/**
	 * @param float $fltUnsharpMaskSigma
	 *
	 * @return $this
	 */
	public function setUnsharpMaskSigma($fltUnsharpMaskSigma)
	{
		$this->fltUnsharpMaskSigma = $fltUnsharpMaskSigma;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getUnsharpMaskSigma()
	{
		return $this->fltUnsharpMaskSigma;
	}


	/**
	 * @param float $fltUnsharpMaskAmount
	 *
	 * @return $this
	 */
	public function setUnsharpMaskAmount($fltUnsharpMaskAmount)
	{
		$this->fltUnsharpMaskAmount = $fltUnsharpMaskAmount;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getUnsharpMaskAmount()
	{
		return $this->fltUnsharpMaskAmount;
	}


	/**
	 * @param float $fltUnsharpMaskThreshold
	 *
	 * @return $this
	 */
	public function setUnsharpMaskThreshold($fltUnsharpMaskThreshold)
	{
		$this->fltUnsharpMaskThreshold = $fltUnsharpMaskThreshold;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getUnsharpMaskThreshold()
	{
		return $this->fltUnsharpMaskThreshold;
	}


	/** @noinspection PhpHierarchyChecksInspection
	 * {@inheritdoc}
	 */
	public function get($image, $width, $height, $mode, $strCacheName, \File $file, $strTarget)
	{
		if (!$width && !$height)
		{
			return false;
		}

		$strCacheName = $this->process($image, $width, $height, $mode, $strCacheName, $file);

		// Set the file permissions when the Safe Mode Hack is used
		if ($this->blnSmhEnabled)
		{
			\Files::getInstance()
				->chmod($strCacheName, 0644);
		}

		if ($strTarget)
		{
			\Files::getInstance()
				->copy($strCacheName, $strTarget);

			return $strTarget;
		}

		// Return the path to new image
		return $strCacheName;
	}


	/**
	 * @param string  $image
	 * @param integer $width
	 * @param integer $height
	 * @param string  $mode
	 * @param string  $strCacheName
	 * @param \File   $objFile
	 *
	 * @return string
	 */
	protected function process($image, $width, $height, $mode, $strCacheName, \File $objFile)
	{
		// detect image format
		$strFormat = strtolower(pathinfo($strCacheName)['extension']); # do not use $objFile->extension because the cache's extension might be set to a fallback extension

		$objProcessBuilder = new ProcessBuilder();
		$objProcessBuilder->add($this->strPath);

		// set the source path
		$strSourcePath = TL_ROOT . '/' . $image;

		// only render a pdf's first page or psd's full layer
		if (in_array($objFile->extension, ['pdf', 'psd']))
		{
			$strSourcePath .= '[0]';
		}

		// set the output path
		$strTargetPath = TL_ROOT . '/' . $strCacheName;


//		if ($objFile->extension == 'pdf')
//		{
			//@todo add density if pdf's size is smaller than final size
//			$objProcessBuilder->add('-density');
//			$objProcessBuilder->add('288');
//		}

		// begin build the exec command
		$objProcessBuilder->add($strSourcePath);

		// set the jpeg quality
		if ($strFormat == 'jpg')
		{
			$objProcessBuilder->add('-quality');
			$objProcessBuilder->add($this->fltJpegQuality);
		}

		$this->resizeAndCrop($objFile, $objProcessBuilder, $width, $height, $mode);
		$this->filterImage($objProcessBuilder);
		$this->blurImage($objProcessBuilder);
		$this->unsharpImage($objProcessBuilder);

		// add target file path
		$objProcessBuilder->add($strTargetPath);

		$objProcess = $objProcessBuilder->getProcess();
		$objProcess->run();

		if (!$objProcess->isSuccessful())
		{
			throw new \RuntimeException('Could not convert image: ' . $objProcess->getErrorOutput());
		}

		return $this->optimize($strCacheName);
	}


	/**
	 * @param \File          $objFile
	 * @param ProcessBuilder $objProcessBuilder
	 * @param string         $width
	 * @param string         $height
	 * @param string         $mode
	 */
	protected function resizeAndCrop(\File $objFile, ProcessBuilder $objProcessBuilder, $width, $height, $mode)
	{
		// the target size
		$intWidth = intval($width);
		$intHeight = intval($height);

		// Mode-specific changes
		if ($intWidth && $intHeight)
		{
			if ($mode == 'proportional')
			{
				if ($objFile->width >= $objFile->height)
				{
					unset($height, $intHeight);
				}
				else
				{
					unset($width, $intWidth);
				}
			}

			if ($mode == 'box')
			{
				if (ceil($objFile->height * $width / $objFile->width) <= $intHeight)
				{
					unset($height, $intHeight);
				}
				else
				{
					unset($width, $intWidth);
				}
			}
		}

		// Resize width and height and crop the image if necessary
		if ($intWidth && $intHeight)
		{
			$fltSrcAspectRatio = $objFile->width / $objFile->height;
			$fltTargetAspectRatio = $intWidth / $intHeight;

			$objProcessBuilder->add('-resize');

			// Advanced crop modes
			switch ($mode)
			{
				case 'left_top':
					$gravity = 'NorthWest';
					break;

				case 'center_top':
					$gravity = 'North';
					break;

				case 'right_top':
					$gravity = 'NorthEast';
					break;

				case 'left_center':
					$gravity = 'West';
					break;

				case 'right_center':
					$gravity = 'East';
					break;

				case 'left_bottom':
					$gravity = 'SouthWest';
					break;

				case 'center_bottom':
					$gravity = 'South';
					break;

				case 'right_bottom':
					$gravity = 'SouthEast';
					break;

				default:
					$gravity = 'Center';
					break;
			}

			if ($fltSrcAspectRatio == $fltTargetAspectRatio)
			{
				$objProcessBuilder->add($intWidth . 'x' . $intHeight);
			}
			else
			{
				if ($fltSrcAspectRatio < $fltTargetAspectRatio)
				{
					$objProcessBuilder->add($intWidth . 'x' . $intHeight . '^');

					// crop image
					$objProcessBuilder->add('-gravity');
					$objProcessBuilder->add($gravity);
					$objProcessBuilder->add('-extent');
					$objProcessBuilder->add($intWidth . 'x' . $intHeight);
				}
				else
				{
					if ($fltSrcAspectRatio > $fltTargetAspectRatio)
					{
						$objProcessBuilder->add('0x' . $intHeight . '^');

						// crop image
						$objProcessBuilder->add('-gravity');
						$objProcessBuilder->add($gravity);
						$objProcessBuilder->add('-extent');
						$objProcessBuilder->add($intWidth . 'x' . $intHeight);
					}
				}
			}
		}

		// resize by width
		else
		{
			if ($intWidth)
			{
				$objProcessBuilder->add('-resize');
				$objProcessBuilder->add($intWidth . 'x0^');
			}

			// resize by height
			else
			{
				if ($intHeight)
				{
					$objProcessBuilder->add('-resize');
					$objProcessBuilder->add('0x' . $intHeight . '^');
				}
			}
		}
	}


	/**
	 * @param ProcessBuilder $objProcessBuilder
	 */
	protected function filterImage(ProcessBuilder $objProcessBuilder)
	{
		$objProcessBuilder->add('-filter');
		$objProcessBuilder->add($this->strFilter);
	}


	/**
	 * @param ProcessBuilder $objProcessBuilder
	 */
	protected function blurImage(ProcessBuilder $objProcessBuilder)
	{
		if ($this->blnBlurEnabled)
		{
			$objProcessBuilder->add('-blur');
			$objProcessBuilder->add(
				$this->fltBlurRadius .
				'x' .
				$this->fltBlurSigma
			);
		}
	}


	/**
	 * @param ProcessBuilder $objProcessBuilder
	 */
	protected function unsharpImage(ProcessBuilder $objProcessBuilder)
	{
		if ($this->blnUnsharpMaskEnabled)
		{
			$objProcessBuilder->add('-unsharp');
			$objProcessBuilder->add(
				sprintf(
					'%sx%s+%s+%s',
					$this->fltUnsharpMaskRadius,
					$this->fltUnsharpMaskSigma,
					$this->fltUnsharpMaskAmount,
					$this->fltUnsharpMaskThreshold
				)
			);
		}
	}


	/**
	 * @param string $strCacheName
	 *
	 * @return string
	 */
	protected function optimize($strCacheName)
	{
		if ($this->objOptimizer)
		{
			return $this->objOptimizer->optimize($strCacheName);
		}

		return $strCacheName;
	}
}
