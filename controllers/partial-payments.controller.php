<?php

require_once "models/partial-payments.model.php";
require_once "models/sales.model.php";
require_once "models/payment-audit.model.php";

class ControllerPartialPayments{

	/*=============================================
	SHOW PARTIAL PAYMENTS
	=============================================*/

	static public function ctrShowPartialPayments($item, $value){

		$table = "partial_payments";

		$answer = ModelPartialPayments::mdlShowPartialPayments($item, $value);

		return $answer;

	}

	/*=============================================
	ADD PARTIAL PAYMENT
	=============================================*/

	static public function ctrAddPartialPayment(){

		if(isset($_POST["saleId"])){

			if(preg_match('/^[0-9]+$/', $_POST["saleId"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["amountPaid"]) &&
			   preg_match('/^[a-zA-Z0-9\s]+$/', $_POST["paymentMethod"]) &&
			   preg_match('/^[a-zA-Z0-9\s\-]*$/', $_POST["referenceNo"])){

				$table = "partial_payments";

				$data = array("sale_id" => $_POST["saleId"],
							 "amount_paid" => $_POST["amountPaid"],
							 "payment_method" => $_POST["paymentMethod"],
							 "reference_no" => $_POST["referenceNo"],
							 "paid_by" => $_SESSION["id"]);

				$answer = ModelPartialPayments::mdlAddPartialPayment($table, $data);

				if($answer == "ok"){

					// Get current sale details
					$sale = ModelSales::mdlShowSales("sales", "id", $_POST["saleId"]);
					
					if($sale){
						$totalPaid = ModelPartialPayments::mdlGetTotalPaidAmount($_POST["saleId"]);
						$remainingBalance = $sale["totalPrice"] - $totalPaid;
						
						// Determine new payment status
						$newStatus = "Partial";
						$statusMessage = "Payment status updated to Partial.";
						
						if($remainingBalance <= 0){
							$newStatus = "Paid";
							$statusMessage = "Payment status updated to Paid. Sale is now fully paid!";
						} elseif($totalPaid > 0) {
							$statusMessage = "Payment status updated to Partial. Remaining balance: $" . number_format($remainingBalance, 2);
						}
						
					// Update sale payment status
					$updateData = array("id" => $_POST["saleId"],
									  "payment_status" => $newStatus);
					
					$updateResult = ModelSales::mdlUpdatePaymentStatus("sales", $updateData);
					
					// Log payment status change if status actually changed
					if($sale["payment_status"] != $newStatus){
						$auditData = array("sale_id" => $_POST["saleId"],
										 "customer_id" => $sale["idCustomer"],
										 "old_status" => $sale["payment_status"],
										 "new_status" => $newStatus,
										 "changed_by" => $_SESSION["id"],
										 "remarks" => "Partial payment recorded: $" . $_POST["amountPaid"] . ". " . $statusMessage);
						
						PaymentAuditModel::mdlAddPaymentAudit("payment_audit", $auditData);
					}
				}

					echo'<script>

						swal({
							  type: "success",
							  title: "Payment Recorded!",
							  html: "Payment of $' . $_POST["amountPaid"] . ' has been successfully recorded.<br><br>' . $statusMessage . '",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						}).then(function(result){

								if(result.value){
								
									window.location = "sales";
								
								}

						});

					</script>';

				}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "Error!",
							  text: "Failed to record payment. Please try again.",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						}).then(function(result){

								if(result.value){
								
									window.location = "sales";
								
								}

						});

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Invalid Data!",
						  text: "Please check the entered data.",
						  showConfirmButton: true,
						  confirmButtonText: "Close"

					}).then(function(result){

							if(result.value){
							
								window.location = "sales";
							
							}

					});

				</script>';

			}

		}

	}

	/*=============================================
	DELETE PARTIAL PAYMENT
	=============================================*/

	static public function ctrDeletePartialPayment(){

		if(isset($_GET["idPayment"])){

			$table ="partial_payments";
			$data = $_GET["idPayment"];

			$answer = ModelPartialPayments::mdlDeletePartialPayment($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "Payment Deleted!",
					  text: "The payment has been successfully deleted.",
					  showConfirmButton: true,
					  confirmButtonText: "Close"

				}).then(function(result){

						if(result.value){
						
							window.location = "sales";
						
						}

				});

			</script>';

			}else{

				echo'<script>

				swal({
					  type: "error",
					  title: "Error!",
					  text: "Failed to delete payment. Please try again.",
					  showConfirmButton: true,
					  confirmButtonText: "Close"

				}).then(function(result){

						if(result.value){
						
							window.location = "sales";
						
						}

				});

			</script>';

			}

		}

	}

	/*=============================================
	GET PAYMENT SUMMARY FOR SALE
	=============================================*/

	static public function ctrGetPaymentSummary($saleId){

		$sale = ModelSales::mdlShowSales("sales", "id", $saleId);
		
		if($sale){
			$totalPaid = ModelPartialPayments::mdlGetTotalPaidAmount($saleId);
			$remainingBalance = $sale["totalPrice"] - $totalPaid;
			
			return array(
				"total_price" => $sale["totalPrice"],
				"total_paid" => $totalPaid,
				"remaining_balance" => $remainingBalance,
				"payment_status" => $sale["payment_status"]
			);
		}
		
		return null;

	}

}
