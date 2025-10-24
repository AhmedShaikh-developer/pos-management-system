<?php

require_once "connection.php";

class ModelCustomerNotes{

	/*=============================================
	SHOW CUSTOMER NOTES
	=============================================*/

	static public function mdlShowCustomerNotes($item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT cn.*, u.name as created_by_name FROM customer_notes cn LEFT JOIN users u ON cn.created_by = u.id WHERE cn.$item = :$item ORDER BY cn.created_at DESC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Connection::connect()->prepare("SELECT cn.*, u.name as created_by_name FROM customer_notes cn LEFT JOIN users u ON cn.created_by = u.id ORDER BY cn.created_at DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	GET SINGLE NOTE
	=============================================*/

	static public function mdlGetNote($noteId){

		$stmt = Connection::connect()->prepare("SELECT * FROM customer_notes WHERE id = :id");

		$stmt -> bindParam(":id", $noteId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ADD CUSTOMER NOTE
	=============================================*/

	static public function mdlAddCustomerNote($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(customer_id, note_text, note_type, created_by) VALUES (:customer_id, :note_text, :note_type, :created_by)");

		$stmt->bindParam(":customer_id", $data["customer_id"], PDO::PARAM_INT);
		$stmt->bindParam(":note_text", $data["note_text"], PDO::PARAM_STR);
		$stmt->bindParam(":note_type", $data["note_type"], PDO::PARAM_STR);
		$stmt->bindParam(":created_by", $data["created_by"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDIT CUSTOMER NOTE
	=============================================*/

	static public function mdlEditCustomerNote($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET note_text = :note_text, note_type = :note_type WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":note_text", $data["note_text"], PDO::PARAM_STR);
		$stmt->bindParam(":note_type", $data["note_type"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE CUSTOMER NOTE
	=============================================*/

	static public function mdlDeleteCustomerNote($table, $data){

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
	CHECK FOR ACTIVE WARNINGS/REMINDERS/INFO
	=============================================*/

	static public function mdlCheckActiveAlerts($customerId){

		$stmt = Connection::connect()->prepare("SELECT COUNT(*) as count, note_type FROM customer_notes WHERE customer_id = :customer_id AND note_type IN ('warning', 'reminder', 'info') GROUP BY note_type");

		$stmt -> bindParam(":customer_id", $customerId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	GET NOTES COUNT BY TYPE
	=============================================*/

	static public function mdlGetNotesCount($customerId, $noteType = null){

		if($noteType){
			$stmt = Connection::connect()->prepare("SELECT COUNT(*) as count FROM customer_notes WHERE customer_id = :customer_id AND note_type = :note_type");
			$stmt -> bindParam(":note_type", $noteType, PDO::PARAM_STR);
		}else{
			$stmt = Connection::connect()->prepare("SELECT COUNT(*) as count FROM customer_notes WHERE customer_id = :customer_id");
		}

		$stmt -> bindParam(":customer_id", $customerId, PDO::PARAM_INT);

		$stmt -> execute();

		$result = $stmt -> fetch();

		return $result["count"];

		$stmt -> close();

		$stmt = null;

	}

}

