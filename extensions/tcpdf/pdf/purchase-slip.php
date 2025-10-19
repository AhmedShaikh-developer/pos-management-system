<?php

require_once "../../../controllers/purchases.controller.php";
require_once "../../../models/purchases.model.php";

require_once "../../../controllers/vendors.controller.php";
require_once "../../../models/vendors.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";

class PrintPurchaseSlip{

	public $reference;

	public function getPurchaseSlipPrint(){

		$itemPurchase = "reference_no";
		$valuePurchase = $this->reference;

		$answerPurchase = ControllerPurchases::ctrShowPurchaseSlips($itemPurchase, $valuePurchase);

		$itemVendor = "id";
		$valueVendor = $answerPurchase["vendor_id"];

		$answerVendor = ControllerVendors::ctrShowVendors($itemVendor, $valueVendor);

		$itemPurchaseItems = "purchase_slip_id";
		$valuePurchaseItems = $answerPurchase["id"];

		$answerItems = PurchasesModel::mdlShowPurchaseItems("purchase_items", $itemPurchaseItems, $valuePurchaseItems);

		require_once('tcpdf_include.php');

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('POS System');
		$pdf->SetTitle('Purchase Slip - '.$answerPurchase["reference_no"]);

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		$pdf->AddPage('P', 'A4');

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
									PURCHASE SLIP
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
							
							<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">VENDOR INFORMATION</div>
							
							<div style="margin-bottom: 5px;"><strong>Name:</strong> $answerVendor[name]</div>
							<div style="margin-bottom: 5px;"><strong>Phone:</strong> $answerVendor[phone]</div>
							<div style="margin-bottom: 5px;"><strong>Address:</strong> $answerVendor[address]</div>

						</div>

					</td>

					<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:50%; vertical-align: top;">

						<div style="font-size: 12px; color: #2c3e50; line-height: 20px; text-align: right;">
							
							<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">PURCHASE DETAILS</div>
							
							<div style="margin-bottom: 5px;"><strong>Reference No:</strong> $answerPurchase[reference_no]</div>
							<div style="margin-bottom: 5px;"><strong>Date:</strong> $answerPurchase[created_at]</div>

						</div>

					</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block2, false, false, false, false, '');


		$block4 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">
				
				<tr>
				
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:40%; text-align:left; font-weight: bold; font-size: 12px;">Product</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:15%; text-align:center; font-weight: bold; font-size: 12px;">Quantity</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Unit Price</td>
					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 12px; width:22.5%; text-align:right; font-weight: bold; font-size: 12px;">Subtotal</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block4, false, false, false, false, '');

		$grandTotalWithTax = 0; // Initialize total with tax included

		foreach ($answerItems as $key => $item) {

			$itemProduct = "id";
			$valueProduct = $item["product_id"];
			$order = "id";

			$answerProduct = ControllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

			// Calculate prices with tax included
			$taxRate = $answerPurchase["tax_percent"] / 100;
			$unitPriceWithTax = $item["unit_price"] * (1 + $taxRate);
			$subtotalWithTax = $unitPriceWithTax * $item["quantity"];
			
			// Add to grand total
			$grandTotalWithTax += $subtotalWithTax;

			$rowColor = ($key % 2 == 0) ? '#ffffff' : '#f8f9fa';

			$block5 = <<<EOF

				<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">

					<tr>
						
						<td style="border: 1px solid #bdc3c7; background-color: $rowColor; padding: 10px; width:40%; text-align:left; font-size: 11px; color: #2c3e50;">
							$answerProduct[description]
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

			$pdf->writeHTML($block5, false, false, false, false, '');

		}

		$block6 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-top: 20px; margin-bottom: 20px;">

				<tr>
				
					<td style="background-color:white; width:55%; text-align:left; padding: 10px;"></td>

					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 15px; width:22.5%; text-align:right; font-size: 14px; font-weight: bold;">TOTAL:</td>

					<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 15px; width:22.5%; text-align:right; font-size: 14px; font-weight: bold;">$ $grandTotalWithTax</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block6, false, false, false, false, '');

		$block7 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 20px;">

				<tr>
				
					<td style="background-color:white; width:55%; text-align:left; padding: 10px;"></td>

					<td style="border: 1px solid #bdc3c7; background-color: #f8f9fa; padding: 12px; width:22.5%; text-align:right; font-size: 12px; color: #2c3e50; font-weight: bold;">Payment Status:</td>

					<td style="border: 1px solid #bdc3c7; background-color: #f8f9fa; padding: 12px; width:22.5%; text-align:right; font-size: 12px; color: #2c3e50; font-weight: bold;">$answerPurchase[payment_status]</td>

				</tr>

				<tr>
				
					<td style="background-color:white; width:55%; text-align:left; padding: 10px;"></td>

					<td style="border: 1px solid #bdc3c7; background-color: #f8f9fa; padding: 12px; width:22.5%; text-align:right; font-size: 12px; color: #2c3e50; font-weight: bold;">Payment Method:</td>

					<td style="border: 1px solid #bdc3c7; background-color: #f8f9fa; padding: 12px; width:22.5%; text-align:right; font-size: 12px; color: #2c3e50; font-weight: bold;">$answerPurchase[payment_method]</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block7, false, false, false, false, '');

		$block8 = <<<EOF

			<table style="font-family: Arial, sans-serif; width:100%; margin-top: 30px;">

				<tr>
				
					<td style="background-color: #2c3e50; color: white; padding: 15px; text-align: center; font-size: 12px; font-style: italic;">
						Thank you for your business!
					</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block8, false, false, false, false, '');

		if($answerPurchase["notes"]){

			$block9 = <<<EOF

				<table style="font-family: Arial, sans-serif; width:100%; margin-top: 20px;">
					
					<tr>
					
						<td style="border: 2px solid #34495e; background-color: #f8f9fa; padding: 15px; width:100%;">

							<div style="font-size: 12px; color: #2c3e50; line-height: 20px;">
								
								<div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; color: #2c3e50;">NOTES</div>
								
								<div style="font-style: italic;">$answerPurchase[notes]</div>

							</div>

						</td>

					</tr>

				</table>

EOF;

			$pdf->writeHTML($block9, false, false, false, false, '');

		}

		$pdf->Output('purchase-slip.pdf', 'I');

	}

}

$purchase = new PrintPurchaseSlip();
$purchase -> reference = $_GET["ref"];
$purchase -> getPurchaseSlipPrint();

?>

