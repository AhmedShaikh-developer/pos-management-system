<?php

require_once "connection.php";

class VendorsModel{

	/*=============================================
	CREATE VENDOR
	=============================================*/

	static public function mdlAddVendor($table, $data){

		try {
			$stmt = Connection::connect()->prepare("INSERT INTO $table(name, phone, address) VALUES (:name, :phone, :address)");

			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);

			if($stmt->execute()){

				return "ok";

			}else{

				return "error";
			
			}
		} catch (PDOException $e) {
			// Allow duplicate phone/address - user wants to allow same phone/address with different names
			// If there's a unique constraint error, we'll handle it, but ideally there shouldn't be one
			$errorCode = $e->getCode();
			if ($errorCode == 23000) { // Integrity constraint violation
				// If there's a unique constraint on phone/address, we need to remove it from DB
				// For now, just return error so user knows there's a DB constraint issue
				return "error";
			}
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	SHOW VENDORS
	=============================================*/

	static public function mdlShowVendors($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

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
	EDIT VENDOR
	=============================================*/

	static public function mdlEditVendor($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET name = :name, phone = :phone, address = :address WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
		$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE VENDOR
	=============================================*/

	static public function mdlDeleteVendor($table, $data){

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

}

