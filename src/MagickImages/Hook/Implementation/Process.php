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
	public function get($image, $width, $height, $mode, $strCacheName, \File $objFile, $strTarget, $objImage)
	{
		if (!$width && !$height)
		{
			return false;
		}

		$strCacheName = $this->process($image, $strCacheName, $objFile, $objImage);

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
     * {@inheritdoc}
     */
    public function fetchImageSize($file)
    {
        $imageSize = $file->imageSize;

        if ($file->isImage && empty($imageSize))
        {
            $imageSize = @getimagesize(TL_ROOT . '/' . $file->path);
        }

        return $imageSize;
	}


	/**
	 * @param string $image        The image path
	 * @param string $strCacheName The cached image path
	 * @param \File  $objFile      The image's File instance
	 * @param \Image $objImage     The image's Image instance
	 *
	 * @return string
	 */
	protected function process($image, $strCacheName, \File $objFile, $objImage)
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

		// begin build the exec command
		$objProcessBuilder->add($strSourcePath);

		// set the jpeg quality
		if ($strFormat == 'jpg')
		{
			$objProcessBuilder->add('-quality');
			$objProcessBuilder->add($this->fltJpegQuality);
		}

		$this->resizeAndCrop($objImage, $objProcessBuilder);
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
	 * @param \Image         $objImage          The image's Image instance
	 * @param ProcessBuilder $objProcessBuilder The ProcessBuilder instance
	 */
	protected function resizeAndCrop($objImage, ProcessBuilder $objProcessBuilder)
	{
		// Fetch the sizes and coordinates from Contao's Image instance
		$arrSizes = $objImage->computeResize();
		
		$objProcessBuilder->add('-resize');
		$objProcessBuilder->add(sprintf
		(
			'%ux%u',
			$arrSizes['target_width'],
			$arrSizes['target_height']
		));

		$objProcessBuilder->add('-crop');
		$objProcessBuilder->add(sprintf
		(
			'%ux%u%+d%+d',
			$arrSizes['width'],
			$arrSizes['height'],
			$arrSizes['target_x'] * -1,
			$arrSizes['target_y'] * -1
		));
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
