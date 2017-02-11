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


/**
 * Class OptimizerChain
 * Used to call multiple optimizers in chain. Called like a regular optimizer it will execute all associated optimizers.
 *
 * @package MagickImages
 */
class OptimizerChain implements IOptimizer
{

    /**
     * The chain
     *
     * @var IOptimizer[]
     */
    protected $chain = [];


    /**
     * Add an optimizer to the chain.
     *
     * @param IOptimizer $optimizer
     */
    public function addOptimizer(IOptimizer $optimizer)
    {
        $this->chain[spl_object_hash($optimizer)] = $optimizer;
    }


    /**
     * Remove the optimizer from the chain.
     *
     * @param IOptimizer $optimizer
     */
    public function removeOptimizer(IOptimizer $optimizer)
    {
        unset($this->chain[spl_object_hash($optimizer)]);
    }


    /**
     * Optimize an image.
     *
     * @param string $strImage  The image path
     * @param string $strTarget The target path, if its not set, use the $image path.
     *
     * @return string Return the optimized image path.
     */
    public function optimize($strImage, $strTarget = null)
    {
        foreach ($this->chain as $optimizer) {
            try {
                $strImage = $optimizer->optimize($strImage, $strTarget);
            } catch (\RuntimeException $e) {
                // Optimizer could not be processed
                // In most cases command not found
                // User is informed because optimizer writes in system log
            }
        }

        return $strImage;
    }
}
