<?php

class PartialPaymentsController{

	/*=============================================
	ADD SALE PARTIAL PAYMENT
	=============================================*/

	static public function ctrAddSalePartialPayment($data){

		$table = "partial_payments";

		$answer = PartialPaymentsModel::mdlAddSalePartialPayment($table, $data);

		return $answer;

	}

	/*=============================================
	ADD PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function ctrAddPurchasePartialPayment($data){

		$table = "purchase_partial_payments";

		$answer = PartialPaymentsModel::mdlAddPurchasePartialPayment($table, $data);

		return $answer;

	}

	/*=============================================
	SHOW SALE PARTIAL PAYMENT
	=============================================*/

	static public function ctrShowSalePartialPayment($sale_id){

		$table = "partial_payments";

		$answer = PartialPaymentsModel::mdlShowSalePartialPayment($table, $sale_id);

		return $answer;

	}

	/*=============================================
	SHOW PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function ctrShowPurchasePartialPayment($purchase_slip_id){

		$table = "purchase_partial_payments";

		$answer = PartialPaymentsModel::mdlShowPurchasePartialPayment($table, $purchase_slip_id);

		return $answer;

	}

	/*=============================================
	UPDATE SALE PARTIAL PAYMENT
	=============================================*/

	static public function ctrUpdateSalePartialPayment($data){

		$table = "partial_payments";

		$answer = PartialPaymentsModel::mdlUpdateSalePartialPayment($table, $data);

		return $answer;

	}

	/*=============================================
	UPDATE PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function ctrUpdatePurchasePartialPayment($data){

		$table = "purchase_partial_payments";

		$answer = PartialPaymentsModel::mdlUpdatePurchasePartialPayment($table, $data);

		return $answer;

	}

	/*=============================================
	DELETE SALE PARTIAL PAYMENT
	=============================================*/

	static public function ctrDeleteSalePartialPayment($sale_id){

		$table = "partial_payments";

		$answer = PartialPaymentsModel::mdlDeleteSalePartialPayment($table, $sale_id);

		return $answer;

	}

	/*=============================================
	DELETE PURCHASE PARTIAL PAYMENT
	=============================================*/

	static public function ctrDeletePurchasePartialPayment($purchase_slip_id){

		$table = "purchase_partial_payments";

		$answer = PartialPaymentsModel::mdlDeletePurchasePartialPayment($table, $purchase_slip_id);

		return $answer;

	}

}

