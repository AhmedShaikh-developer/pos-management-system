<?php
//============================================================+
// File name   : example_2d_svgi.php
// Version     : 1.0.000
// Begin       : 2011-07-21
// Last Update : 2013-03-19
// Author      : Ahmed Shaikh - 
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2009-2013 Ahmed Shaikh - 
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
// You should have received a copy of the GNU Lesser General Public License
// along with POS.  If not, see <http://www.gnu.org/licenses/>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description : Example for POS_barcodes_2d.php class
//
//============================================================+

/**
 * @file
 * Example for POS_barcodes_2d.php class
 * @package pos.system
 * @author Ahmed Shaikh
 * @version 1.0.009
 */

// include 2D barcode class (search for installation path)
require_once(dirname(__FILE__).'/POS_barcodes_2d_include.php');

// set the barcode content and type
$barcodeobj = new POS2DBarcode('http://www.POS.org', 'DATAMATRIX');

// output the barcode as SVG inline code
echo $barcodeobj->getBarcodeSVGcode(6, 6, 'black');

//============================================================+
// END OF FILE
//============================================================+
