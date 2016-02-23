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

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class OptiPngOptimizer
 *
 * @package MagickImages
 */
class OptiPngOptimizer implements IOptimizer
{

	/**
	 * @var string
	 */
	protected $strPath = 'optipng';


	/**
	 * @var int
	 */
	protected $intLevel = 2;


	/**
	 * @param string $strPath
	 *
	 * @return $this
	 */
	public function setPath($strPath)
	{
		$this->strPath = (string)$strPath;

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
	 * @param int $level
	 *
	 * @return $this
	 */
	public function setLevel($level)
	{
		$this->intLevel = (int)$level;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getLevel()
	{
		return $this->intLevel;
	}


	/**
	 * {@inheritdoc}
	 */
	public function optimize($strImage, $strTarget = null)
	{
		$objFile = new \File($strImage, true);

		if (!$strTarget)
		{
			$strTarget = $strImage;
		}

		if ($objFile->exists() && in_array($objFile->extension, array('png', 'bmp', 'gif', 'pnm', 'tiff')))
		{
			$objProcessBuilder = new ProcessBuilder();
			$objProcessBuilder
				->add($this->strPath)
				->add('-o')
				->add($this->intLevel)
				->add('-out')
				->add(TL_ROOT . '/' . $strTarget)
				->add(TL_ROOT . '/' . $strImage);
			$objProcess = $objProcessBuilder->getProcess();
			$objProcess->run();

			if (!$objProcess->isSuccessful())
			{
				throw new \RuntimeException('Could not execute optipng: ' . $objProcess->getErrorOutput());
			}
		}

		return $strTarget;
	}
}
