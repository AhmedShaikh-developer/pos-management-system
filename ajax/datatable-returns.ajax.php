<?php

require_once "../controllers/returns.controller.php";
require_once "../models/returns.model.php";

require_once "../controllers/sales.controller.php";
require_once "../models/sales.model.php";

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

require_once "../controllers/users.controller.php";
require_once "../models/users.model.php";

class ReturnsTable{

	/*=============================================
	SHOW RETURNS TABLE
	=============================================*/

	public function showReturnsTable(){

		$item = null;
		$value = null;

		$returns = ControllerReturns::ctrShowReturns($item, $value);

		if(count($returns) == 0){

			$jsonData = '{"data":[]}';

			echo $jsonData;

			return;
		}

		$jsonData = '{
			"data":[';

				for($i=0; $i < count($returns); $i++){

					$itemSale = "id";
					$valueSale = $returns[$i]["sale_id"];

					$sale = ControllerSales::ctrShowSales($itemSale, $valueSale);

					$itemProduct = "id";
					$valueProduct = $returns[$i]["product_id"];
					$order = "id";

					$product = controllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

					$itemUser = "id";
					$valueUser = $returns[$i]["handled_by"];

					$user = ControllerUsers::ctrShowUsers($itemUser, $valueUser);

					if($returns[$i]["return_type"] == "refund"){

						$type = "<button class='btn btn-danger btn-xs'>Refund</button>";

					}else{

						$type = "<button class='btn btn-primary btn-xs'>Exchange</button>";

					}

					$buttons =  "<div class='btn-group'><a class='btn btn-warning btnPrintReturn' href='extensions/tcpdf/pdf/return-slip.php?code=".$returns[$i]["return_code"]."' target='_blank'><i class='fa fa-print'></i></a><button class='btn btn-danger btnDeleteReturn' idReturn='".$returns[$i]["id"]."'><i class='fa fa-trash'></i></button></div>";

					$jsonData .='[
						"'.($i+1).'",
						"'.$returns[$i]["return_code"].'",
						"'.$sale["code"].'",
						"'.$product["description"].'",
						"'.$returns[$i]["quantity_returned"].'",
						"$ '.number_format($returns[$i]["refund_amount"],2).'",
						"'.$type.'",
						"'.$returns[$i]["reason"].'",
						"'.$user["name"].'",
						"'.$returns[$i]["created_at"].'",
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
ACTIVATE RETURNS TABLE
=============================================*/

$activateReturns = new ReturnsTable();
$activateReturns -> showReturnsTable();

