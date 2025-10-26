<?php

class ControllerPurchases{

	/*=============================================
	SHOW PURCHASE SLIPS
	=============================================*/

	static public function ctrShowPurchaseSlips($item, $value){

		$table = "purchase_slips";

		$answer = PurchasesModel::mdlShowPurchaseSlips($table, $item, $value);

		return $answer;

	}

	/*=============================================
	CREATE PURCHASE SLIP
	=============================================*/

	static public function ctrCreatePurchaseSlip(){

		if(isset($_POST["newPurchaseSlip"])){

			$productsList = json_decode($_POST["productsList"], true);

			foreach ($productsList as $key => $value) {

			   $tableProducts = "products";

			    $item = "id";
			    $valueProductId = $value["id"];
			    $order = "id";

			    $getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

				$item1b = "stock";
				$value1b = $value["quantity"] + $getProduct["stock"];

				$newStock = ProductsModel::mdlUpdateProduct($tableProducts, $item1b, $value1b, $valueProductId);

			}

			$table = "purchase_slips";

			$data = array("vendor_id"=>$_POST["selectVendor"],
						   "total_amount"=>$_POST["purchaseTotal"],
						   "tax_percent"=>$_POST["newTaxPurchase"],
						   "payment_status"=>$_POST["paymentStatus"],
						   "payment_method"=>$_POST["paymentMethod"],
						   "reference_no"=>$_POST["newPurchaseSlip"],
						   "notes"=>$_POST["purchaseNotes"]);

			$answer = PurchasesModel::mdlAddPurchaseSlip($table, $data);

			if($answer == "ok"){

				$item = "reference_no";
				$value = $_POST["newPurchaseSlip"];
				$purchaseSlip = PurchasesModel::mdlShowPurchaseSlips($table, $item, $value);

				$tableItems = "purchase_items";

				foreach ($productsList as $key => $value) {

					$dataItem = array("purchase_slip_id"=>$purchaseSlip["id"],
									   "product_id"=>$value["id"],
									   "quantity"=>$value["quantity"],
									   "unit_price"=>$value["price"],
									   "subtotal"=>$value["totalPrice"]);

			PurchasesModel::mdlAddPurchaseItem($tableItems, $dataItem);

			}

			// Save partial payment details if status is Partial
			if($_POST["paymentStatus"] == "Partial" && isset($_POST["partialAmountPaid"]) && $_POST["partialAmountPaid"] > 0){

				$partialData = array("purchase_slip_id" => $purchaseSlip["id"],
									 "amount_paid" => $_POST["partialAmountPaid"],
									 "balance_remaining" => $_POST["partialBalanceRemaining"],
									 "payment_method" => $_POST["paymentMethod"],
									 "reference_no" => isset($_POST["partialPaymentReference"]) ? $_POST["partialPaymentReference"] : "",
									 "notes" => isset($_POST["partialPaymentNotes"]) ? $_POST["partialPaymentNotes"] : "",
									 "paid_by" => $_SESSION["id"]);

				PartialPaymentsController::ctrAddPurchasePartialPayment($partialData);

			}

			echo'<script>

			localStorage.removeItem("range");

			swal({
				  type: "success",
				  title: "The purchase slip has been successfully added",
				  showConfirmButton: true,
				  confirmButtonText: "Close"
				  }).then((result) => {
							if (result.value) {

							window.location = "purchases";

							}
						})

			</script>';

		}

		}

	}

	/*=============================================
	EDIT PURCHASE SLIP
	=============================================*/

	static public function ctrEditPurchaseSlip(){

		if(isset($_POST["editPurchaseSlip"])){

			$table = "purchase_slips";

			$item = "id";
			$value = $_POST["purchaseId"];

			$getPurchaseSlip = PurchasesModel::mdlShowPurchaseSlips($table, $item, $value);

			if($_POST["productsList"] == ""){

				$productsList = json_encode([]);
				$productChange = false;

			}else{

				$productsList = $_POST["productsList"];
				$productChange = true;
			}

			if($productChange){

				$tableItems = "purchase_items";
				$itemPurchase = "purchase_slip_id";
				$valuePurchase = $getPurchaseSlip["id"];

				$oldItems = PurchasesModel::mdlShowPurchaseItems($tableItems, $itemPurchase, $valuePurchase);

				foreach ($oldItems as $key => $value) {

					$tableProducts = "products";
					$item = "id";
					$valueProductId = $value["product_id"];
					$order = "id";

					$getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

					$item1b = "stock";
					$value1b = $getProduct["stock"] - $value["quantity"];

					$revertStock = ProductsModel::mdlUpdateProduct($tableProducts, $item1b, $value1b, $valueProductId);

				}

				PurchasesModel::mdlDeletePurchaseItems($tableItems, $getPurchaseSlip["id"]);

				$productsList_2 = json_decode($productsList, true);

				foreach ($productsList_2 as $key => $value) {

					$tableProducts_2 = "products";
					$item_2 = "id";
					$value_2 = $value["id"];
					$order = "id";

					$getProduct_2 = ProductsModel::mdlShowProducts($tableProducts_2, $item_2, $value_2, $order);

					$item1b_2 = "stock";
					$value1b_2 = $getProduct_2["stock"] + $value["quantity"];

					$newStock_2 = ProductsModel::mdlUpdateProduct($tableProducts_2, $item1b_2, $value1b_2, $value_2);

					$dataItem = array("purchase_slip_id"=>$getPurchaseSlip["id"],
									   "product_id"=>$value["id"],
									   "quantity"=>$value["quantity"],
									   "unit_price"=>$value["price"],
									   "subtotal"=>$value["totalPrice"]);

					PurchasesModel::mdlAddPurchaseItem($tableItems, $dataItem);

				}

			}

		$data = array("id"=>$getPurchaseSlip["id"],
					   "vendor_id"=>$_POST["selectVendor"],
					   "total_amount"=>$_POST["purchaseTotal"],
					   "tax_percent"=>$_POST["newTaxPurchase"],
					   "payment_status"=>$_POST["paymentStatus"],
					   "payment_method"=>$_POST["paymentMethod"],
					   "reference_no"=>$_POST["editPurchaseSlip"],
					   "notes"=>$_POST["purchaseNotes"]);

		$answer = PurchasesModel::mdlEditPurchaseSlip($table, $data);

		if($answer == "ok"){

			// Handle partial payment details
			$paymentStatus = $_POST["paymentStatus"];

			if($paymentStatus == "Partial" && isset($_POST["partialAmountPaid"]) && $_POST["partialAmountPaid"] > 0){

				// Check if partial payment already exists for this purchase
				$existingPartialPayment = PartialPaymentsController::ctrShowPurchasePartialPayment($getPurchaseSlip["id"]);

				$partialData = array("purchase_slip_id" => $getPurchaseSlip["id"],
									 "amount_paid" => $_POST["partialAmountPaid"],
									 "balance_remaining" => $_POST["partialBalanceRemaining"],
									 "payment_method" => $_POST["paymentMethod"],
									 "reference_no" => isset($_POST["partialPaymentReference"]) ? $_POST["partialPaymentReference"] : "",
									 "notes" => isset($_POST["partialPaymentNotes"]) ? $_POST["partialPaymentNotes"] : "",
									 "paid_by" => $_SESSION["id"]);

				if($existingPartialPayment){
					// Update existing partial payment
					PartialPaymentsController::ctrUpdatePurchasePartialPayment($partialData);
				}else{
					// Add new partial payment
					PartialPaymentsController::ctrAddPurchasePartialPayment($partialData);
				}

			}elseif($paymentStatus != "Partial"){
				// If status changed from Partial to Paid/Unpaid, delete partial payment record
				PartialPaymentsController::ctrDeletePurchasePartialPayment($getPurchaseSlip["id"]);
			}

			echo'<script>

			localStorage.removeItem("range");

			swal({
				  type: "success",
				  title: "The purchase slip has been edited correctly",
				  showConfirmButton: true,
				  confirmButtonText: "Close"
				  }).then((result) => {
							if (result.value) {

							window.location = "purchases";

							}
						})

			</script>';

		}

		}

	}

	/*=============================================
	DELETE PURCHASE SLIP
	=============================================*/

	static public function ctrDeletePurchaseSlip(){

		if(isset($_GET["idPurchaseSlip"])){

			$table = "purchase_slips";

			$item = "id";
			$value = $_GET["idPurchaseSlip"];

			$getPurchaseSlip = PurchasesModel::mdlShowPurchaseSlips($table, $item, $value);

			$tableItems = "purchase_items";
			$itemPurchase = "purchase_slip_id";
			$valuePurchase = $getPurchaseSlip["id"];

			$items = PurchasesModel::mdlShowPurchaseItems($tableItems, $itemPurchase, $valuePurchase);

			foreach ($items as $key => $value) {

				$tableProducts = "products";
				$item = "id";
				$valueProductId = $value["product_id"];
				$order = "id";

				$getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

				$item1b = "stock";
				$value1b = $getProduct["stock"] - $value["quantity"];

				$revertStock = ProductsModel::mdlUpdateProduct($tableProducts, $item1b, $value1b, $valueProductId);

			}

			PurchasesModel::mdlDeletePurchaseItems($tableItems, $getPurchaseSlip["id"]);

			$answer = PurchasesModel::mdlDeletePurchaseSlip($table, $_GET["idPurchaseSlip"]);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The purchase slip has been deleted successfully",
					  showConfirmButton: true,
					  confirmButtonText: "Close",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "purchases";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	PURCHASE SLIPS DATE RANGE
	=============================================*/

	static public function ctrPurchaseSlipsDateRange($initialDate, $finalDate){

		$table = "purchase_slips";

		$answer = PurchasesModel::mdlPurchaseSlipsDateRange($table, $initialDate, $finalDate);

		return $answer;
		
	}

	/*=============================================
	GET VENDOR BALANCE
	=============================================*/

	static public function ctrGetVendorBalance($vendorId){

		$table = "purchase_slips";

		$answer = PurchasesModel::mdlGetVendorBalance($table, $vendorId);

		return $answer;
		
	}

}

