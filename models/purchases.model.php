<?php

require_once 'connection.php';

class PurchasesModel{

	/*=============================================
	SHOW PURCHASE SLIPS
	=============================================*/

	static public function mdlShowPurchaseSlips($table, $item, $value){

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
	ADD PURCHASE SLIP
	=============================================*/

	static public function mdlAddPurchaseSlip($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(vendor_id, total_amount, tax_percent, payment_status, payment_method, reference_no, notes) VALUES (:vendor_id, :total_amount, :tax_percent, :payment_status, :payment_method, :reference_no, :notes)");

		$stmt->bindParam(":vendor_id", $data["vendor_id"], PDO::PARAM_INT);
		$stmt->bindParam(":total_amount", $data["total_amount"], PDO::PARAM_STR);
		$stmt->bindParam(":tax_percent", $data["tax_percent"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_status", $data["payment_status"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":reference_no", $data["reference_no"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDIT PURCHASE SLIP
	=============================================*/

	static public function mdlEditPurchaseSlip($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET vendor_id = :vendor_id, total_amount = :total_amount, tax_percent = :tax_percent, payment_status = :payment_status, payment_method = :payment_method, notes = :notes WHERE id = :id");

		$stmt->bindParam(":vendor_id", $data["vendor_id"], PDO::PARAM_INT);
		$stmt->bindParam(":total_amount", $data["total_amount"], PDO::PARAM_STR);
		$stmt->bindParam(":tax_percent", $data["tax_percent"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_status", $data["payment_status"], PDO::PARAM_STR);
		$stmt->bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);
		$stmt->bindParam(":notes", $data["notes"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE PURCHASE SLIP
	=============================================*/

	static public function mdlDeletePurchaseSlip($table, $data){

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
	SHOW PURCHASE ITEMS
	=============================================*/

	static public function mdlShowPurchaseItems($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ADD PURCHASE ITEM
	=============================================*/

	static public function mdlAddPurchaseItem($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(purchase_slip_id, product_id, quantity, unit_price, subtotal) VALUES (:purchase_slip_id, :product_id, :quantity, :unit_price, :subtotal)");

		$stmt->bindParam(":purchase_slip_id", $data["purchase_slip_id"], PDO::PARAM_INT);
		$stmt->bindParam(":product_id", $data["product_id"], PDO::PARAM_INT);
		$stmt->bindParam(":quantity", $data["quantity"], PDO::PARAM_INT);
		$stmt->bindParam(":unit_price", $data["unit_price"], PDO::PARAM_STR);
		$stmt->bindParam(":subtotal", $data["subtotal"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE PURCHASE ITEMS BY SLIP ID
	=============================================*/

	static public function mdlDeletePurchaseItems($table, $slipId){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE purchase_slip_id = :purchase_slip_id");

		$stmt -> bindParam(":purchase_slip_id", $slipId, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	PURCHASE SLIPS DATE RANGE
	=============================================*/

	static public function mdlPurchaseSlipsDateRange($table, $initialDate, $finalDate){

		if($initialDate == null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	

		}else if($initialDate == $finalDate){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE created_at like '%$finalDate%' ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$actualDate = new DateTime();
			$actualDate ->add(new DateInterval("P1D"));
			$actualDatePlusOne = $actualDate->format("Y-m-d");

			$finalDate2 = new DateTime($finalDate);
			$finalDate2 ->add(new DateInterval("P1D"));
			$finalDatePlusOne = $finalDate2->format("Y-m-d");

			if($finalDatePlusOne == $actualDatePlusOne){

				$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE created_at BETWEEN '$initialDate' AND '$finalDatePlusOne' ORDER BY id DESC");

			}else{

				$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE created_at BETWEEN '$initialDate' AND '$finalDate' ORDER BY id DESC");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	GET VENDOR BALANCE
	=============================================*/

	static public function mdlGetVendorBalance($table, $vendorId){

		$stmt = Connection::connect()->prepare("SELECT SUM(total_amount) as balance FROM $table WHERE vendor_id = :vendor_id AND payment_status = 'Unpaid'");

		$stmt -> bindParam(":vendor_id", $vendorId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

}

