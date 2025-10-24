<?php

class ControllerPaymentAudit{

	/*=============================================
	LOG PAYMENT STATUS CHANGE
	=============================================*/

	static public function ctrLogPaymentStatusChange($saleId, $customerId, $oldStatus, $newStatus, $remarks = ""){

		$table = "payment_audit";

		$data = array("sale_id" => $saleId,
					   "customer_id" => $customerId,
					   "old_status" => $oldStatus,
					   "new_status" => $newStatus,
					   "changed_by" => $_SESSION["id"],
					   "remarks" => $remarks);

		$answer = PaymentAuditModel::mdlAddPaymentAudit($table, $data);

		return $answer;

	}

	/*=============================================
	SHOW PAYMENT AUDIT
	=============================================*/

	static public function ctrShowPaymentAudit($item, $value){

		$table = "payment_audit";

		$answer = PaymentAuditModel::mdlShowPaymentAudit($table, $item, $value);

		return $answer;

	}

	/*=============================================
	GET AUDIT BY CUSTOMER
	=============================================*/

	static public function ctrGetAuditByCustomer($customerId){

		$table = "payment_audit";

		$answer = PaymentAuditModel::mdlGetAuditByCustomer($table, $customerId);

		return $answer;

	}

	/*=============================================
	UPDATE PAYMENT STATUS
	=============================================*/

	static public function ctrUpdatePaymentStatus(){

		if(isset($_POST["updatePaymentStatus"])){

			$table = "sales";

			$item = "id";
			$value = $_POST["saleId"];

			$sale = ModelSales::mdlShowSales($table, $item, $value);

			$oldStatus = $sale["payment_status"];
			$newStatus = $_POST["newPaymentStatus"];
			$remarks = $_POST["paymentRemarks"];

			if($oldStatus != $newStatus){

				$stmt = Connection::connect()->prepare("UPDATE $table SET payment_status = :payment_status WHERE id = :id");

				$stmt->bindParam(":payment_status", $newStatus, PDO::PARAM_STR);
				$stmt->bindParam(":id", $value, PDO::PARAM_INT);

				if($stmt->execute()){

					self::ctrLogPaymentStatusChange($sale["id"], $sale["idCustomer"], $oldStatus, $newStatus, $remarks);

					echo '<script>
						swal({
							type: "success",
							title: "Payment status updated successfully!",
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

	}

}

