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
 * Class AdvPngOptimizer
 *
 * @package MagickImages
 */
class AdvPngOptimizer implements IOptimizer
{

    /**
     * @var string
     */
    protected $strPath = 'advpng';


    /**
     * @var string
     */
    protected $strLevel = 'normal';


    /**
     * @param mixed $strPath
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
     * @param string $strLevel
     *
     * @return $this
     */
    public function setLevel($strLevel)
    {
        $this->strLevel = (string)$strLevel;

        return $this;
    }


    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->strLevel;
    }


    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function optimize($strImage, $strTarget = null)
    {
        $objFile = new \File($strImage, true);

        if (!$strTarget) {
            $strTarget = $strImage;
        }

        if ($objFile->exists() && $objFile->extension == 'png') {
            // advpng does not support output files,
            // so we need to copy the file before optimize it
            if ($strImage != $strTarget) {
                \Files::getInstance()
                    ->copy($strImage, $strTarget);
            }

            $objProcessBuilder = new ProcessBuilder();
            $objProcessBuilder->add($this->strPath);
            $objProcessBuilder->add('-z');

            switch ($this->strLevel) {
                case 'store':
                    $objProcessBuilder->add('--shrink-store');
                    break;
                case 'fast':
                    $objProcessBuilder->add('--shrink-fast');
                    break;
                case 'extra':
                    $objProcessBuilder->add('--shrink-extra');
                    break;
                case 'insane':
                    $objProcessBuilder->add('--shrink-insane');
                    break;
                default:
                    $objProcessBuilder->add('--shrink-normal');
                    break;
            }

            $objProcessBuilder->add(TL_ROOT.'/'.$strTarget);
            $objProcess = $objProcessBuilder->getProcess();
            $objProcess->run();

            if (!$objProcess->isSuccessful()) {
                throw new \RuntimeException('Could not execute advpng: '.$objProcess->getErrorOutput());
            }

            return $strTarget;
        }

        return $strImage;
    }
}
