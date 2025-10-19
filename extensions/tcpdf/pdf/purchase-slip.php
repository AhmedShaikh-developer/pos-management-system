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

			<table style="font-size:10px; padding:5px 10px;">
			
				<tr>
				
					<td style="border: 1px solid #666; background-color:white; width:540px">

						<div style="font-size:8.5px; text-align:right; line-height:15px;">
							
							<br>
							PURCHASE SLIP

						</div>

					</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block1, false, false, false, false, '');

		$block2 = <<<EOF

			<table style="font-size:10px; padding:5px 10px;">
				
				<tr>
				
					<td style="border: 1px solid #666; background-color:white; width:540px">

						<div style="font-size:8.5px; text-align:left; line-height:15px;">
							
							<br>
							Vendor: $answerVendor[name]

							<br>
							Phone: $answerVendor[phone]

							<br>
							Address: $answerVendor[address]

						</div>

					</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block2, false, false, false, false, '');

		$block3 = <<<EOF

			<table style="font-size:10px; padding:5px 10px;">
				
				<tr>
				
					<td style="border-bottom: 1px solid #666; background-color:white; width:270px">

						Reference No: $answerPurchase[reference_no]

					</td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:270px; text-align:right">
					
						Date: $answerPurchase[created_at]

					</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block3, false, false, false, false, '');

		$block4 = <<<EOF

			<table style="font-size:10px; padding:5px 10px;">
				
				<tr>
				
					<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Product</td>
					<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Quantity</td>
					<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Unit Price</td>
					<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Subtotal</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block4, false, false, false, false, '');

		foreach ($answerItems as $key => $item) {

			$itemProduct = "id";
			$valueProduct = $item["product_id"];
			$order = "id";

			$answerProduct = ControllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

			$block5 = <<<EOF

				<table style="font-size:10px; padding:5px 10px;">

					<tr>
						
						<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">
							$answerProduct[description]
						</td>

						<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">
							$item[quantity]
						</td>

						<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$ 
							$item[unit_price]
						</td>

						<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$ 
							$item[subtotal]
						</td>


					</tr>

				</table>


EOF;

			$pdf->writeHTML($block5, false, false, false, false, '');

		}

		$netAmount = $answerPurchase["total_amount"] / (1 + ($answerPurchase["tax_percent"] / 100));
		$taxAmount = $answerPurchase["total_amount"] - $netAmount;

		$block6 = <<<EOF

			<table style="font-size:10px; padding:5px 10px;">

				<tr>

					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">Net Total:</td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">$ $netAmount</td>

				</tr>
				
				<tr>

					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">Tax ($answerPurchase[tax_percent]%):</td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">$ $taxAmount</td>

				</tr>

				<tr>
				
					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">Total:</td>

					<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:right">$ $answerPurchase[total_amount]</td>

				</tr>

				<tr>
				
					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

					<td style="background-color:white; width:100px; text-align:right">Payment Status:</td>

					<td style="background-color:white; width:100px; text-align:right">$answerPurchase[payment_status]</td>

				</tr>

				<tr>
				
					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

					<td style="background-color:white; width:100px; text-align:right">Payment Method:</td>

					<td style="background-color:white; width:100px; text-align:right">$answerPurchase[payment_method]</td>

				</tr>

			</table>

EOF;

		$pdf->writeHTML($block6, false, false, false, false, '');

		if($answerPurchase["notes"]){

			$block7 = <<<EOF

				<table style="font-size:10px; padding:5px 10px;">
					
					<tr>
					
						<td style="border: 1px solid #666; background-color:white; width:540px">

							<div style="font-size:8.5px; text-align:left; line-height:15px;">
								
								<br>
								Notes: $answerPurchase[notes]

							</div>

						</td>

					</tr>

				</table>

EOF;

			$pdf->writeHTML($block7, false, false, false, false, '');

		}

		$pdf->Output('purchase-slip.pdf', 'I');

	}

}

$purchase = new PrintPurchaseSlip();
$purchase -> reference = $_GET["ref"];
$purchase -> getPurchaseSlipPrint();

?>

