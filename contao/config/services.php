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

$container['magickimages.optimizer.advpng'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\AdvPngOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_advpng_path'])
		->setLevel($GLOBALS['TL_CONFIG']['magickimages_advpng_level']);

	return $optimizer;
};

$container['magickimages.optimizer.optipng'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\OptiPngOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_optipng_path'])
		->setLevel($GLOBALS['TL_CONFIG']['magickimages_optipng_optimization_level']);

	return $optimizer;
};

$container['magickimages.optimizer.pngrewrite'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\PngRewriteOptimizer();
	$optimizer->setPath($GLOBALS['TL_CONFIG']['magickimages_pngrewrite_path']);

	return $optimizer;
};

$container['magickimages.optimizer'] = function ($container)
{
	$chain = new \MagickImages\Optimizer\OptimizerChain();

	foreach ((array)$GLOBALS['TL_CONFIG']['magickimages_optimizers'] as $optimizer)
	{
		$chain->addOptimizer($container['magickimages.optimizer.' . $optimizer]);
	}

	return $chain;
};

$container['magickimages.impl.process'] = function ($container)
{
	$hook = new \MagickImages\Hook\Implementation\Process();
	$hook->setPath($GLOBALS['TL_CONFIG']['magickimages_convert_path'])
		->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality'])
		->setFilter($GLOBALS['TL_CONFIG']['magickimages_filter'])
		->setBlurEnabled($GLOBALS['TL_CONFIG']['magickimages_blur'])
		->setBlurRadius($GLOBALS['TL_CONFIG']['magickimages_blur_radius'])
		->setBlurSigma($GLOBALS['TL_CONFIG']['magickimages_blur_sigma'])
		->setUnsharpMaskEnabled($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
		->setUnsharpMaskRadius($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'])
		->setUnsharpMaskSigma($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'])
		->setUnsharpMaskAmount($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'])
		->setUnsharpMaskThreshold($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold'])
		->setOptimizer($container['magickimages.optimizer']);

	return $hook;
};

$container['magickimages.impl.imagick'] = function ($container)
{
	$hook = new \MagickImages\Hook\Implementation\Imagick();
	$hook->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality'])
		->setFilter($GLOBALS['TL_CONFIG']['magickimages_filter'])
		->setBlurEnabled($GLOBALS['TL_CONFIG']['magickimages_blur'])
		->setBlurRadius($GLOBALS['TL_CONFIG']['magickimages_blur_radius'])
		->setBlurSigma($GLOBALS['TL_CONFIG']['magickimages_blur_sigma'])
		->setUnsharpMaskEnabled($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask'])
		->setUnsharpMaskRadius($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_radius'])
		->setUnsharpMaskSigma($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_sigma'])
		->setUnsharpMaskAmount($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_amount'])
		->setUnsharpMaskThreshold($GLOBALS['TL_CONFIG']['magickimages_unsharp_mask_threshold']);

	//@todo no optimizer supported because they run as process?

	return $hook;
};

$container['magickimages.hook'] = $container->share(
	function ($container)
	{
		return $container['magickimages.impl.' . $GLOBALS['TL_CONFIG']['magickimages_implementation']];
	}
);
