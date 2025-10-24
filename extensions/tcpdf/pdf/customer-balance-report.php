<?php

require_once "../../../models/connection.php";

require_once "../../../controllers/customers.controller.php";
require_once "../../../models/customers.model.php";

require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('L', 'A4');

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
							CUSTOMER BALANCE REPORT
						</td>
					</tr>
				</table>

			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block1, false, false, false, false, '');

$block2 = <<<EOF

	<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">
		
		<tr>
		
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:25%; text-align:left; font-weight: bold; font-size: 10px;">Customer Name</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:15%; text-align:center; font-weight: bold; font-size: 10px;">Phone</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:15%; text-align:right; font-weight: bold; font-size: 10px;">Total Purchases</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:15%; text-align:right; font-weight: bold; font-size: 10px;">Paid Amount</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:15%; text-align:right; font-weight: bold; font-size: 10px;">Unpaid Balance</td>
			<td style="border: 2px solid #34495e; background-color: #34495e; color: white; padding: 8px; width:15%; text-align:center; font-weight: bold; font-size: 10px;">Status</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block2, false, false, false, false, '');

$item = null;
$value = null;

$customers = ControllerCustomers::ctrShowCustomers($item, $value);

foreach ($customers as $customer) {

	$itemSales = "idCustomer";
	$valueSales = $customer["id"];

	$sales = ControllerSales::ctrShowSales($itemSales, $valueSales);

	$totalPurchases = 0;
	$totalPaid = 0;

	if($sales){

		if(isset($sales["totalPrice"])){
			$totalPurchases = $sales["totalPrice"];
			$totalPaid = $sales["totalPrice"];
		}else{
			foreach ($sales as $sale) {
				$totalPurchases += $sale["totalPrice"];
				$totalPaid += $sale["totalPrice"];
			}
		}

	}

	$unpaidBalance = $totalPurchases - $totalPaid;

	if($unpaidBalance == 0){
		$status = "Paid";
		$bgColor = "#d4edda";
	}else{
		$status = "Unpaid";
		$bgColor = "#f8d7da";
	}

	$block3 = <<<EOF

		<table style="font-family: Arial, sans-serif; width:100%; margin-bottom: 0px; border-collapse: collapse;">
			
			<tr>
				
				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:25%; text-align:left; font-size: 9px;">
					$customer[name]
				</td>

				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:15%; text-align:center; font-size: 9px;">
					$customer[phone]
				</td>

				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:15%; text-align:right; font-size: 9px;">
					$totalPurchases
				</td>

				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:15%; text-align:right; font-size: 9px;">
					$totalPaid
				</td>

				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:15%; text-align:right; font-size: 9px;">
					$unpaidBalance
				</td>

				<td style="border: 2px solid #34495e; background-color:$bgColor; padding: 6px; width:15%; text-align:center; font-size: 9px;">
					$status
				</td>

			</tr>

		</table>

EOF;

	$pdf->writeHTML($block3, false, false, false, false, '');

}

$pdf->Output('customer-balance-report.pdf', 'I');

?>

