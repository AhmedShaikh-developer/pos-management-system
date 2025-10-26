<?php

require_once "connection.php";

class PartialPaymentsModel{

	/*=============================================
	ADD PARTIAL PAYMENT FOR SALE
	=============================================*/

	static public function mdlAddSalePartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(sale_id, amount_paid, balance_remaining, payment_method, reference_no, notes, paid_by) VALUES (:sale_id, :amount_paid, :balance_remaining, :payment_method, :reference_no, :notes, :paid_by)");

		$stmt->bindParam(":sale_id", $data["sale_id"], PDO::PARAM_INT);
		$stmt->bindParam(":amount_paid", $data["amount_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":balance_remaining", $data["balance_remaining"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);
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
	ADD PARTIAL PAYMENT FOR PURCHASE
	=============================================*/

	static public function mdlAddPurchasePartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(purchase_slip_id, amount_paid, balance_remaining, payment_method, reference_no, notes, paid_by) VALUES (:purchase_slip_id, :amount_paid, :balance_remaining, :payment_method, :reference_no, :notes, :paid_by)");

		$stmt->bindParam(":purchase_slip_id", $data["purchase_slip_id"], PDO::PARAM_INT);
		$stmt->bindParam(":amount_paid", $data["amount_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":balance_remaining", $data["balance_remaining"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);
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
	SHOW PARTIAL PAYMENT BY SALE ID
	=============================================*/

	static public function mdlShowSalePartialPayment($table, $sale_id){

		$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sale_id = :sale_id");

		$stmt -> bindParam(":sale_id", $sale_id, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SHOW PARTIAL PAYMENT BY PURCHASE ID
	=============================================*/

	static public function mdlShowPurchasePartialPayment($table, $purchase_slip_id){

		$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE purchase_slip_id = :purchase_slip_id");

		$stmt -> bindParam(":purchase_slip_id", $purchase_slip_id, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	UPDATE SALE PARTIAL PAYMENT
	=============================================*/

	static public function mdlUpdateSalePartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET amount_paid = :amount_paid, balance_remaining = :balance_remaining, payment_method = :payment_method, reference_no = :reference_no, notes = :notes WHERE sale_id = :sale_id");

		$stmt->bindParam(":amount_paid", $data["amount_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":balance_remaining", $data["balance_remaining"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);
		$stmt->bindParam(":sale_id", $data["sale_id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	UPDATE PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function mdlUpdatePurchasePartialPayment($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET amount_paid = :amount_paid, balance_remaining = :balance_remaining, payment_method = :payment_method, reference_no = :reference_no, notes = :notes WHERE purchase_slip_id = :purchase_slip_id");

		$stmt->bindParam(":amount_paid", $data["amount_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":balance_remaining", $data["balance_remaining"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);
		$stmt->bindParam(":purchase_slip_id", $data["purchase_slip_id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE SALE PARTIAL PAYMENT
	=============================================*/

	static public function mdlDeleteSalePartialPayment($table, $sale_id){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE sale_id = :sale_id");

		$stmt -> bindParam(":sale_id", $sale_id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	DELETE PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function mdlDeletePurchasePartialPayment($table, $purchase_slip_id){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE purchase_slip_id = :purchase_slip_id");

		$stmt -> bindParam(":purchase_slip_id", $purchase_slip_id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

}

