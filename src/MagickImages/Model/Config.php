<?php
/**
 * E-POSTBUSINESS API integration for Contao Open Source CMS
 *
 * Copyright (c) 2015-2016 Richard Henkenjohann
 *
 * @package E-POST
 * @author  Richard Henkenjohann <richard-epost@henkenjohann.me>
 */

namespace MagickImages\Model;

use Ferienpass\Model\AbstractSingleModel;


/**
 * Class Config
 * @property string $fallback_extension
 * @package MagickImages\Model
 */
class Config extends AbstractSingleModel
{

    /**
     * {@inheritdoc}
     */
    protected static $strTable = 'tl_magickimages_config';
}
