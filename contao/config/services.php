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

use MagickImages\Model\Config as MagickImagesConfig;


$container['magickimages.optimizer.advpng'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\AdvPngOptimizer();
    $optimizer
        ->setPath(MagickImagesConfig::getInstance()->advpng_path)
        ->setLevel(MagickImagesConfig::getInstance()->advpng_level);

	return $optimizer;
};

$container['magickimages.optimizer.optipng'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\OptiPngOptimizer();
    $optimizer
        ->setPath(MagickImagesConfig::getInstance()->optipng_path)
        ->setLevel(MagickImagesConfig::getInstance()->optipng_optimization_level);

	return $optimizer;
};

$container['magickimages.optimizer.pngrewrite'] = function ($container)
{
	$optimizer = new \MagickImages\Optimizer\PngRewriteOptimizer();
    $optimizer->setPath(MagickImagesConfig::getInstance()->pngrewrite_path);

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
    $hook
        ->setPath(MagickImagesConfig::getInstance()->convert_path)
		->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality'])
		->setSmhEnabled($GLOBALS['TL_CONFIG']['useFTP'])
        ->setFilter(MagickImagesConfig::getInstance()->filter)
        ->setBlurEnabled(MagickImagesConfig::getInstance()->blur)
        ->setBlurRadius(MagickImagesConfig::getInstance()->blur_radius)
        ->setBlurSigma(MagickImagesConfig::getInstance()->blur_sigma)
        ->setUnsharpMaskEnabled(MagickImagesConfig::getInstance()->unsharp_mask)
        ->setUnsharpMaskRadius(MagickImagesConfig::getInstance()->unsharp_mask_radius)
        ->setUnsharpMaskSigma(MagickImagesConfig::getInstance()->unsharp_mask_sigma)
        ->setUnsharpMaskAmount(MagickImagesConfig::getInstance()->unsharp_mask_amount)
        ->setUnsharpMaskThreshold(MagickImagesConfig::getInstance()->unsharp_mask_threshold)
		->setOptimizer($container['magickimages.optimizer']);

	return $hook;
};

$container['magickimages.impl.imagick'] = function ($container)
{
	$hook = new \MagickImages\Hook\Implementation\Imagick();
    $hook
        ->setJpegQuality($GLOBALS['TL_CONFIG']['jpgQuality'])
        ->setSmhEnabled($GLOBALS['TL_CONFIG']['useFTP'])
        ->setFilter(MagickImagesConfig::getInstance()->filter)
        ->setBlurEnabled(MagickImagesConfig::getInstance()->blur)
        ->setBlurRadius(MagickImagesConfig::getInstance()->blur_radius)
        ->setBlurSigma(MagickImagesConfig::getInstance()->blur_sigma)
        ->setUnsharpMaskEnabled(MagickImagesConfig::getInstance()->unsharp_mask)
        ->setUnsharpMaskRadius(MagickImagesConfig::getInstance()->unsharp_mask_radius)
        ->setUnsharpMaskSigma(MagickImagesConfig::getInstance()->unsharp_mask_sigma)
        ->setUnsharpMaskAmount(MagickImagesConfig::getInstance()->unsharp_mask_amount)
        ->setUnsharpMaskThreshold(MagickImagesConfig::getInstance()->unsharp_mask_threshold);

	//@todo no optimizer supported because they run as process?

	return $hook;
};

$container['magickimages.hook'] = $container->share(
	function ($container)
	{
        return $container['magickimages.impl.'.MagickImagesConfig::getInstance()->implementation];
	}
);
