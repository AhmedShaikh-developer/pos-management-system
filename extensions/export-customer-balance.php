<?php

require_once "../models/connection.php";

require_once "../controllers/customers.controller.php";
require_once "../models/customers.model.php";

require_once "../controllers/sales.controller.php";
require_once "../models/sales.model.php";

if(isset($_GET["report"])){

	$item = null;
	$value = null;

	$customers = ControllerCustomers::ctrShowCustomers($item, $value);

	$name = $_GET["report"].'.xls';

	header('Expires: 0');
	header('Cache-control: private');
	header("Content-type: application/vnd.ms-excel");
	header("Cache-Control: cache, must-revalidate"); 
	header('Content-Description: File Transfer');
	header('Last-Modified: '.date('D, d M Y H:i:s'));
	header("Pragma: public"); 
	header('Content-Disposition:; filename="'.$name.'"');
	header("Content-Transfer-Encoding: binary");

	echo utf8_decode("<table border='1'> 

			<tr> 
			<td style='font-weight:bold; border:1px solid #eee;'>Customer Name</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Phone</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Total Purchases</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Paid Amount</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Unpaid Balance</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Last Transaction</td>
			<td style='font-weight:bold; border:1px solid #eee;'>Status</td>
			</tr>");

	foreach ($customers as $row => $customer){

		$itemSales = "idCustomer";
		$valueSales = $customer["id"];

		$sales = ControllerSales::ctrShowSales($itemSales, $valueSales);

		$totalPurchases = 0;
		$totalPaid = 0;
		$lastTransaction = $customer["lastPurchase"];

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
		}else{
			$status = "Unpaid";
		}

		echo utf8_decode("<tr>
					<td style='border:1px solid #eee;'>".$customer["name"]."</td>
					<td style='border:1px solid #eee;'>".$customer["phone"]."</td>
				<td style='border:1px solid #eee;'>".number_format($totalPurchases,2)."</td>
				<td style='border:1px solid #eee;'>".number_format($totalPaid,2)."</td>
				<td style='border:1px solid #eee;'>".number_format($unpaidBalance,2)."</td>
					<td style='border:1px solid #eee;'>".$lastTransaction."</td>
					<td style='border:1px solid #eee;'>".$status."</td>
					</tr>");

	}

	echo "</table>";

}

?>

