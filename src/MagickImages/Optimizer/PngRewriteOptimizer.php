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
 * Class PngRewriteOptimizer
 *
 * @package MagickImages
 */
class PngRewriteOptimizer implements IOptimizer
{

	/**
	 * @var string
	 */
	protected $strPath = 'pngrewrite';


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
	 * {@inheritdoc}
	 */
	public function optimize($strImage, $strTarget = null)
	{
		$objFile = new \File($strImage, true);

		if (!$strTarget)
		{
			$strTarget = $strImage;
		}

		if ($objFile->exists() && $objFile->extension == 'png')
		{
			$objProcessBuilder = new ProcessBuilder();
			$objProcessBuilder->add($this->strPath);
			$objProcessBuilder->add(TL_ROOT . '/' . $strImage);
			$objProcessBuilder->add(TL_ROOT . '/' . $strTarget);
			$objProcess = $objProcessBuilder->getProcess();
			$objProcess->run();

			if (!$objProcess->isSuccessful())
			{
				throw new \RuntimeException('Could not execute pngrewrite: ' . $objProcess->getErrorOutput());
			}
		}

		return $strTarget;
	}
}
