<?php

require_once "../../../controllers/returns.controller.php";
require_once "../../../models/returns.model.php";

require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";

require_once "../../../controllers/customers.controller.php";
require_once "../../../models/customers.model.php";

require_once "../../../controllers/users.controller.php";
require_once "../../../models/users.model.php";

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

// ---------------------------------------------------------

$item = "return_code";
$value = $_GET["code"];

$returns = ControllerReturns::ctrShowReturns($item, $value);

$returnCode = $returns["return_code"];
$saleId = $returns["sale_id"];
$productId = $returns["product_id"];
$quantityReturned = $returns["quantity_returned"];
$returnType = $returns["return_type"];
$reason = $returns["reason"];
$refundAmount = $returns["refund_amount"];
$handledBy = $returns["handled_by"];
$createdAt = $returns["created_at"];

$itemSale = "id";
$valueSale = $saleId;

$sale = ControllerSales::ctrShowSales($itemSale, $valueSale);

$itemCustomer = "id";
$valueCustomer = $sale["idCustomer"];

$customer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

$itemProduct = "id";
$valueProduct = $productId;
$order = "id";

$product = controllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

$itemUser = "id";
$valueUser = $handledBy;

$user = ControllerUsers::ctrShowUsers($itemUser, $valueUser);

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
							RETURN SLIP
						</td>
					</tr>
				</table>

			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block1, false, false, false, false, '');

// ---------------------------------------------------------

$block2 = <<<EOF

	<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 15px;">
		
		<tr>
		
			<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:50%; vertical-align: top;">

				<div style="font-size: 12px; color: #2c3e50; line-height: 20px;">
					
					<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">CUSTOMER INFORMATION</div>
					
					<div style="margin-bottom: 5px;"><strong>Name:</strong> $customer[name]</div>
					<div style="margin-bottom: 5px;"><strong>ID:</strong> $customer[idDocument]</div>
					<div style="margin-bottom: 5px;"><strong>Phone:</strong> $customer[phone]</div>
					<div style="margin-bottom: 5px;"><strong>Email:</strong> $customer[email]</div>

				</div>

			</td>

			<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:50%; vertical-align: top;">

				<div style="font-size: 12px; color: #2c3e50; line-height: 20px; text-align: right;">
					
					<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">RETURN DETAILS</div>
					
					<div style="margin-bottom: 5px;"><strong>Return Code:</strong> $returnCode</div>
					<div style="margin-bottom: 5px;"><strong>Original Sale:</strong> $sale[code]</div>
					<div style="margin-bottom: 5px;"><strong>Date:</strong> $createdAt</div>
					<div style="margin-bottom: 5px;"><strong>Handled By:</strong> $user[name]</div>
					<div style="margin-bottom: 5px;"><strong>Type:</strong> $returnType</div>
					<div style="margin-bottom: 5px;"><strong>Reason:</strong> $reason</div>

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
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:15%; text-align:center; font-weight: bold; font-size: 12px;">Qty Returned</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Unit Price</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Refund Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block3, false, false, false, false, '');

// ---------------------------------------------------------

$block4 = <<<EOF

	<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">
		
		<tr>
			
			<td style="border: 2px solid #34495e; background-color:#ffffff; padding: 10px; width:40%; text-align:left; font-size: 11px;">
			
				$product[description]
			
			</td>

			<td style="border: 2px solid #34495e; background-color:#ffffff; padding: 10px; width:15%; text-align:center; font-size: 11px;">
			
				$quantityReturned
			
			</td>

			<td style="border: 2px solid #34495e; background-color:#ffffff; padding: 10px; width:22.5%; text-align:right; font-size: 11px;">
			
				$ $product[sellingPrice]
			
			</td>

			<td style="border: 2px solid #34495e; background-color:#ffffff; padding: 10px; width:22.5%; text-align:right; font-size: 11px;">
			
				$ $refundAmount
			
			</td>


		</tr>

	</table>

EOF;

$pdf->writeHTML($block4, false, false, false, false, '');

// ---------------------------------------------------------

$block5 = <<<EOF

	<table style="font-family: Arial, sans-serif; width:100%; margin-top: 15px; border-collapse: collapse;">
	
		<tr>
		
			<td style="background-color:white; width:55%; text-align:center"></td>

			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:center; font-weight: bold; font-size: 12px;">
				
				REFUND TOTAL:
				
			</td>

			<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 13px; color: #2c3e50;">
				
				$ $refundAmount
				
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($block5, false, false, false, false, '');

// ---------------------------------------------------------
//CLOSE AND OUTPUT PDF DOCUMENT
$pdf->Output('return-'.$returnCode.'.pdf', 'I');

?>

