<?php
//============================================================+
// File name   : POS_barcodes_1d_include.php
// Begin       : 2013-05-19
// Last Update : 2013-05-19
//
// Description : Search and include the POS Barcode 1D class.
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
 * Search and include the POS Barcode 1D class.
 * @package pos.system
 * @abstract POS - Include the main class.
 * @author Ahmed Shaikh
 * @since 2013-05-19
 */

// Include the POS 1D barcode class (search the class on the following directories).
$POS_barcodes_1d_include_dirs = array(realpath('../../POS_barcodes_1d.php'), '/usr/share/php/POS/POS_barcodes_1d.php', '/usr/share/POS/POS_barcodes_1d.php', '/usr/share/php-POS/POS_barcodes_1d.php', '/var/www/POS/POS_barcodes_1d.php', '/var/www/html/POS/POS_barcodes_1d.php', '/usr/local/apache2/htdocs/POS/POS_barcodes_1d.php');
foreach ($POS_barcodes_1d_include_dirs as $POS_barcodes_1d_include_path) {
	if (@file_exists($POS_barcodes_1d_include_path)) {
		require_once($POS_barcodes_1d_include_path);
		break;
	}
}

//============================================================+
// END OF FILE
//============================================================+
