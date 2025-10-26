<?php

require_once "../controllers/purchases.controller.php";
require_once "../models/purchases.model.php";

require_once "../controllers/vendors.controller.php";
require_once "../models/vendors.model.php";

class PurchasesTable{

	/*=============================================
	SHOW PURCHASES TABLE
	=============================================*/

	public function showPurchasesTable(){

		$item = null;
		$value = null;

		$purchases = ControllerPurchases::ctrShowPurchaseSlips($item, $value);

		if(count($purchases) == 0){

			$jsonData = '{"data":[]}';

			echo $jsonData;

			return;
		}

		$jsonData = '{
			"data":[';

				for($i=0; $i < count($purchases); $i++){

					$itemVendor = "id";
					$valueVendor = $purchases[$i]["vendor_id"];

					$vendor = ControllerVendors::ctrShowVendors($itemVendor, $valueVendor);

					if($purchases[$i]["payment_status"] == "Paid"){

						$status = "<button class='btn btn-success btn-xs'>Paid</button>";

					}else{

						$status = "<button class='btn btn-danger btn-xs'>Unpaid</button>";

					}

					$buttons =  "<div class='btn-group'><a class='btn btn-warning btnPrintPurchase' href='extensions/tcpdf/pdf/purchase-slip.php?ref=".$purchases[$i]["reference_no"]."' target='_blank'><i class='fa fa-print'></i></a><button class='btn btn-primary btnEditPurchase' idPurchase='".$purchases[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeletePurchase' idPurchase='".$purchases[$i]["id"]."'><i class='fa fa-trash'></i></button></div>";

					$jsonData .='[
						"'.($i+1).'",
						"'.$purchases[$i]["reference_no"].'",
						"'.$vendor["name"].'",
						"'.number_format($purchases[$i]["total_amount"],2).'",
						"'.$status.'",
						"'.$purchases[$i]["payment_method"].'",
						"'.$purchases[$i]["created_at"].'",
						"'.$buttons.'"
					],';
				}

				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 

			}';

		echo $jsonData;
	}
}

/*=============================================
ACTIVATE PURCHASES TABLE
=============================================*/

$activatePurchases = new PurchasesTable();
$activatePurchases -> showPurchasesTable();

