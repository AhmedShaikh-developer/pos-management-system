<?php

require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once "../../../controllers/customers.controller.php";
require_once "../../../models/customers.model.php";

require_once "../../../controllers/users.controller.php";
require_once "../../../models/users.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";

class printBill{

public $code;

public function getBillPrinting(){

//WE BRING THE INFORMATION OF THE SALE

$itemSale = "code";
$valueSale = $this->code;

$answerSale = ControllerSales::ctrShowSales($itemSale, $valueSale);

$saledate = substr($answerSale["saledate"],0,-8);
$products = json_decode($answerSale["products"], true);
$netPrice = number_format($answerSale["netPrice"],2);
$tax = number_format($answerSale["tax"],2);
$totalPrice = number_format($answerSale["totalPrice"],2);

//TRAEMOS LA INFORMACIÓN DEL Customer

$itemCustomer = "id";
$valueCustomer = $answerSale["idCustomer"];

$answerCustomer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

//TRAEMOS LA INFORMACIÓN DEL Seller

$itemSeller = "id";
$valueSeller = $answerSale["idSeller"];

$answerSeller = ControllerUsers::ctrShowUsers($itemSeller, $valueSeller);

//REQUERIMOS LA CLASE POS

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A4');

//---------------------------------------------------------

$block1 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 15px;">
			
				<tr>
				
					<td style="background-color: #2c3e50; color: white; padding: 15px; width:100%; border-radius: 5px 5px 0 0;">
						
						<table style="width:100%;">
							<tr>
								<td style="font-size: 18px; font-weight: bold; vertical-align: middle;">
									Ali's Furniture House
								</td>
								<td style="text-align: right; font-size: 24px; font-weight: bold; vertical-align: middle;">
									SALES RECEIPT
								</td>
							</tr>
						</table>

		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($block1, false, false, false, false, '');

$block2 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 15px;">
				
				<tr>
				
					<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:50%; vertical-align: top;">

						<div style="font-size: 12px; color: #2c3e50; line-height: 20px;">
							
							<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">CUSTOMER INFORMATION</div>
							
							<div style="margin-bottom: 5px;"><strong>Name:</strong> $answerCustomer[name]</div>
							<div style="margin-bottom: 5px;"><strong>Seller:</strong> $answerSeller[name]</div>

						</div>

		</td>

					<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:50%; vertical-align: top;">

						<div style="font-size: 12px; color: #2c3e50; line-height: 20px; text-align: right;">
							
							<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">SALES DETAILS</div>
							
							<div style="margin-bottom: 5px;"><strong>Invoice No:</strong> $valueSale</div>
							<div style="margin-bottom: 5px;"><strong>Date:</strong> $saledate</div>

						</div>

		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($block2, false, false, false, false, '');

// ---------------------------------------------------------


$block3 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">
				
				<tr>
				
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:40%; text-align:left; font-weight: bold; font-size: 12px;">Product</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:15%; text-align:center; font-weight: bold; font-size: 12px;">Quantity</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Unit Price</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Subtotal</td>

	</tr>

			</table>

EOF;

$pdf->writeHTML($block3, false, false, false, false, '');

$grandTotalWithTax = 0; // Initialize total with tax included

foreach ($products as $key => $item) {

// Calculate prices with tax included
$taxRate = $answerSale["tax"] / $answerSale["netPrice"]; // Calculate tax rate from existing data
$unitPriceWithTax = $item["price"] * (1 + $taxRate);
$subtotalWithTax = $unitPriceWithTax * $item["quantity"];

// Add to grand total
$grandTotalWithTax += $subtotalWithTax;

$rowColor = ($key % 2 == 0) ? '#ffffff' : '#f8f9fa';

$block4 = <<<EOF

				<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">

					<tr>
						
						<td style="border: 1px solid #bdc3c7; background-color: $rowColor; padding: 10px; width:40%; text-align:left; font-size: 11px; color: #2c3e50;">
							$item[description]
		</td>

						<td style="border: 1px solid #bdc3c7; background-color: $rowColor; padding: 10px; width:15%; text-align:center; font-size: 11px; color: #2c3e50;">
							$item[quantity]
		</td>

						<td style="border: 1px solid #bdc3c7; background-color: $rowColor; padding: 10px; width:22.5%; text-align:right; font-size: 11px; color: #2c3e50; font-weight: bold;">
							$ $unitPriceWithTax
						</td>

						<td style="border: 1px solid #bdc3c7; background-color: $rowColor; padding: 10px; width:22.5%; text-align:right; font-size: 11px; color: #2c3e50; font-weight: bold;">
							$ $subtotalWithTax
		</td>

	</tr>

				</table>

EOF;

$pdf->writeHTML($block4, false, false, false, false, '');

}

// ---------------------------------------------------------
$block5 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-top: 20px; margin-bottom: 20px;">

				<tr>
				
					<td style="background-color:white; width:55%; text-align:left; padding: 10px;"></td>

					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 15px; width:22.5%; text-align:right; font-size: 14px; font-weight: bold;">TOTAL:</td>

					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 15px; width:22.5%; text-align:right; font-size: 14px; font-weight: bold;">$ $grandTotalWithTax</td>

	</tr>

			</table>

EOF;

$pdf->writeHTML($block5, false, false, false, false, '');

$block6 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-top: 30px;">

				<tr>
				
					<td style="background-color: #2c3e50; color: white; padding: 15px; text-align: center; font-size: 12px; font-style: italic;">
			Thank you for your purchase!
		</td>

	</tr>

</table>

EOF;

$pdf->writeHTML($block6, false, false, false, false, '');


// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

// $pdf->Output('bill.pdf', 'D');

$pdf->Output('bill.pdf');

}

}

$bill = new printBill();
$bill -> code = $_GET["code"];
$bill -> getBillPrinting();

?>
