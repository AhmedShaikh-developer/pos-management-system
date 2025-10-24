<?php

require_once 'connection.php';

class PaymentAuditModel{

	/*=============================================
	ADD PAYMENT AUDIT LOG
	=============================================*/

	static public function mdlAddPaymentAudit($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(sale_id, customer_id, old_status, new_status, changed_by, remarks) VALUES (:sale_id, :customer_id, :old_status, :new_status, :changed_by, :remarks)");

		$stmt->bindParam(":sale_id", $data["sale_id"], PDO::PARAM_INT);
		$stmt->bindParam(":customer_id", $data["customer_id"], PDO::PARAM_INT);
		$stmt->bindParam(":old_status", $data["old_status"], PDO::PARAM_STR);
		$stmt->bindParam(":new_status", $data["new_status"], PDO::PARAM_STR);
		$stmt->bindParam(":changed_by", $data["changed_by"], PDO::PARAM_INT);
		$stmt->bindParam(":remarks", $data["remarks"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	SHOW PAYMENT AUDIT
	=============================================*/

	static public function mdlShowPaymentAudit($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	GET AUDIT BY CUSTOMER
	=============================================*/

	static public function mdlGetAuditByCustomer($table, $customerId){

		$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE customer_id = :customer_id ORDER BY id DESC");

		$stmt -> bindParam(":customer_id", $customerId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

}

