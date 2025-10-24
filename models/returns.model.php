<?php

require_once 'connection.php';

class ReturnsModel{

	/*=============================================
	SHOW RETURNS
	=============================================*/

	static public function mdlShowReturns($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ADD RETURN
	=============================================*/

	static public function mdlAddReturn($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(return_code, sale_id, product_id, quantity_returned, return_type, reason, refund_amount, handled_by) VALUES (:return_code, :sale_id, :product_id, :quantity_returned, :return_type, :reason, :refund_amount, :handled_by)");

		$stmt->bindParam(":return_code", $data["return_code"], PDO::PARAM_STR);
		$stmt->bindParam(":sale_id", $data["sale_id"], PDO::PARAM_INT);
		$stmt->bindParam(":product_id", $data["product_id"], PDO::PARAM_INT);
		$stmt->bindParam(":quantity_returned", $data["quantity_returned"], PDO::PARAM_INT);
		$stmt->bindParam(":return_type", $data["return_type"], PDO::PARAM_STR);
		$stmt->bindParam(":reason", $data["reason"], PDO::PARAM_STR);
		$stmt->bindParam(":refund_amount", $data["refund_amount"], PDO::PARAM_STR);
		$stmt->bindParam(":handled_by", $data["handled_by"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE RETURN
	=============================================*/

	static public function mdlDeleteReturn($table, $data){

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
	GET RETURNS BY SALE ID
	=============================================*/

	static public function mdlGetReturnsBySale($table, $saleId){

		$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sale_id = :sale_id ORDER BY id DESC");

		$stmt -> bindParam(":sale_id", $saleId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

}

