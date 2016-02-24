<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'MagickImages',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Library
	'MagickImages\Image' => 'system/modules/magickimages/library/MagickImages/Image.php',
	'MagickImages\File'  => 'system/modules/magickimages/library/MagickImages/File.php',
));
