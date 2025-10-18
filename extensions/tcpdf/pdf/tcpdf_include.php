<?php
//============================================================+
// File name   : POS_include.php
// Begin       : 2008-05-14
// Last Update : 2014-12-10
//
// Description : Search and include the POS library.
//
// Author: Ahmed Shaikh
//
// (c) Copyright:
//               Ahmed Shaikh
//               
//               
//               
//============================================================+

/**
 * Search and include the POS library.
 * @package pos.system
 * @abstract POS - Include the main class.
 * @author Ahmed Shaikh
 * @since 2013-05-14
 */

// always load alternative config file for examples
require_once('config/POS_config_alt.php');

// Include the main POS library (search the library on the following directories).
$POS_include_dirs = array(
	realpath('../POS.php'),
	'/usr/share/php/POS/POS.php',
	'/usr/share/POS/POS.php',
	'/usr/share/php-POS/POS.php',
	'/var/www/POS/POS.php',
	'/var/www/html/POS/POS.php',
	'/usr/local/apache2/htdocs/POS/POS.php'
);
foreach ($POS_include_dirs as $POS_include_path) {
	if (@file_exists($POS_include_path)) {
		require_once($POS_include_path);
		break;
	}
}

//============================================================+
// END OF FILE
//============================================================+
