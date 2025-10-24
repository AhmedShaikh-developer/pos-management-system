<?php

class ControllerReturns{

	/*=============================================
	SHOW RETURNS
	=============================================*/

	static public function ctrShowReturns($item, $value){

		$table = "returns";

		$answer = ReturnsModel::mdlShowReturns($table, $item, $value);

		return $answer;

	}

	/*=============================================
	CREATE RETURN
	=============================================*/

	static public function ctrCreateReturn(){

		if(isset($_POST["newReturn"])){

			$productsList = json_decode($_POST["returnProductsList"], true);

			$table = "returns";

			foreach ($productsList as $key => $value) {

				$tableProducts = "products";
				$item = "id";
				$valueProductId = $value["id"];
				$order = "id";

				$getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

				$item1b = "stock";
				$value1b = $value["quantity"] + $getProduct["stock"];

				$newStock = ProductsModel::mdlUpdateProduct($tableProducts, $item1b, $value1b, $valueProductId);

				$data = array("return_code" => $_POST["newReturn"],
							   "sale_id" => $_POST["saleId"],
							   "product_id" => $value["id"],
							   "quantity_returned" => $value["quantity"],
							   "return_type" => $_POST["returnType"],
							   "reason" => $_POST["returnReason"],
							   "refund_amount" => $value["totalPrice"],
							   "handled_by" => $_SESSION["id"]);

				$answer = ReturnsModel::mdlAddReturn($table, $data);

			}

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The return has been successfully added",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then((result) => {
								if (result.value) {

								window.location = "returns";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	DELETE RETURN
	=============================================*/

	static public function ctrDeleteReturn(){

		if(isset($_GET["idReturn"])){

			$table = "returns";

			$item = "id";
			$value = $_GET["idReturn"];

			$getReturn = ReturnsModel::mdlShowReturns($table, $item, $value);

			$tableProducts = "products";
			$item = "id";
			$valueProductId = $getReturn["product_id"];
			$order = "id";

			$getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

			$item1b = "stock";
			$value1b = $getProduct["stock"] - $getReturn["quantity_returned"];

			$revertStock = ProductsModel::mdlUpdateProduct($tableProducts, $item1b, $value1b, $valueProductId);

			$answer = ReturnsModel::mdlDeleteReturn($table, $_GET["idReturn"]);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The return has been deleted successfully",
					  showConfirmButton: true,
					  confirmButtonText: "Close",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "returns";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	GET RETURNS BY SALE
	=============================================*/

	static public function ctrGetReturnsBySale($saleId){

		$table = "returns";

		$answer = ReturnsModel::mdlGetReturnsBySale($table, $saleId);

		return $answer;

	}

}

