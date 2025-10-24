<?php

require_once "connection.php";

class ModelPartialPayments{

	/*=============================================
	SHOW PARTIAL PAYMENTS
	=============================================*/

	static public function mdlShowPartialPayments($item, $value){

		$table = "partial_payments";

		$stmt = Connection::connect()->prepare("SELECT pp.*, u.name as paid_by_name FROM $table pp LEFT JOIN users u ON pp.paid_by = u.id WHERE pp.$item = :$item ORDER BY pp.paid_at DESC");

		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ADD PARTIAL PAYMENT
	=============================================*/

	static public function mdlAddPartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(sale_id, amount_paid, payment_method, reference_no, paid_by) VALUES (:sale_id, :amount_paid, :payment_method, :reference_no, :paid_by)");

		$stmt->bindParam(":sale_id", $data["sale_id"], PDO::PARAM_INT);
		$stmt->bindParam(":amount_paid", $data["amount_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":paid_by", $data["paid_by"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE PARTIAL PAYMENT
	=============================================*/

	static public function mdlDeletePartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

		$stmt -> bindParam(":id", $data, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	GET TOTAL PAID AMOUNT FOR SALE
	=============================================*/

	static public function mdlGetTotalPaidAmount($saleId){

		$stmt = Connection::connect()->prepare("SELECT SUM(amount_paid) as total_paid FROM partial_payments WHERE sale_id = :sale_id");

		$stmt -> bindParam(":sale_id", $saleId, PDO::PARAM_INT);

		$stmt -> execute();

		$result = $stmt -> fetch();

		return $result ? $result["total_paid"] : 0;

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	GET PAYMENT HISTORY FOR SALE
	=============================================*/

	static public function mdlGetPaymentHistory($saleId){

		$stmt = Connection::connect()->prepare("SELECT pp.*, u.name as paid_by_name FROM partial_payments pp LEFT JOIN users u ON pp.paid_by = u.id WHERE pp.sale_id = :sale_id ORDER BY pp.paid_at DESC");

		$stmt -> bindParam(":sale_id", $saleId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

}
