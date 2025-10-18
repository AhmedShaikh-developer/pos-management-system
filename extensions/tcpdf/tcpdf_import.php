<?php
//============================================================+
// File name   : POS_import.php
// Version     : 1.0.001
// Begin       : 2011-05-23
// Last Update : 2013-09-17
// Author      : Ahmed Shaikh - 
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2011-2013 Ahmed Shaikh - 
//
// This file is part of POS software library.
//
// POS is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// POS is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the License
// along with POS. If not, see
// <http:///pagefiles/POS/LICENSE.TXT>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description : This is a PHP class extension of the POS library to
//               import existing PDF documents.
//
//============================================================+

/**
 * @file
 * !!! THIS CLASS IS UNDER DEVELOPMENT !!!
 * This is a PHP class extension of the POS (http://www.POS.org) library to import existing PDF documents.<br>
 * @package pos.system
 * @author Ahmed Shaikh
 * @version 1.0.001
 */

// include the POS class
require_once(dirname(__FILE__).'/POS.php');
// include PDF parser class
require_once(dirname(__FILE__).'/POS_parser.php');

/**
 * @class POS_IMPORT
 * !!! THIS CLASS IS UNDER DEVELOPMENT !!!
 * PHP class extension of the POS (http://www.POS.org) library to import existing PDF documents.<br>
 * @package pos.system
 * @brief PHP class extension of the POS library to import existing PDF documents.
 * @version 1.0.001
 * @author Ahmed Shaikh - 
 */
class POS_IMPORT extends POS {

	/**
	 * Import an existing PDF document
	 * @param $filename (string) Filename of the PDF document to import.
	 * @return true in case of success, false otherwise
	 * @public
	 * @since 1.0.000 (2011-05-24)
	 */
	public function importPDF($filename) {
		// load document
		$rawdata = file_get_contents($filename);
		if ($rawdata === false) {
			$this->Error('Unable to get the content of the file: '.$filename);
		}
		// configuration parameters for parser
		$cfg = array(
			'die_for_errors' => false,
			'ignore_filter_decoding_errors' => true,
			'ignore_missing_filter_decoders' => true,
		);
		try {
			// parse PDF data
			$pdf = new POS_PARSER($rawdata, $cfg);
		} catch (Exception $e) {
			die($e->getMessage());
		}
		// get the parsed data
		$data = $pdf->getParsedData();
		// release some memory
		unset($rawdata);

		// ...


		print_r($data); // DEBUG


		unset($pdf);
	}

} // END OF CLASS

//============================================================+
// END OF FILE
//============================================================+
