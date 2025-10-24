<?php

require_once "../controllers/payment-audit.controller.php";
require_once "../models/payment-audit.model.php";

require_once "../controllers/sales.controller.php";
require_once "../models/sales.model.php";

class AjaxPaymentAudit{

	/*=============================================
	GET AUDIT LOG BY SALE
	=============================================*/

	public $saleId;

	public function ajaxGetAuditBySale(){

		$item = "sale_id";
		$value = $this->saleId;

		$answer = ControllerPaymentAudit::ctrShowPaymentAudit($item, $value);

		echo json_encode($answer);

	}

	/*=============================================
	GET AUDIT LOG BY CUSTOMER
	=============================================*/

	public $customerId;

	public function ajaxGetAuditByCustomer(){

		$answer = ControllerPaymentAudit::ctrGetAuditByCustomer($this->customerId);

		echo json_encode($answer);

	}

}

/*=============================================
GET AUDIT BY SALE
=============================================*/

if(isset($_POST["saleId"])){

	$audit = new AjaxPaymentAudit();
	$audit -> saleId = $_POST["saleId"];
	$audit -> ajaxGetAuditBySale();

}

/*=============================================
GET AUDIT BY CUSTOMER
=============================================*/

if(isset($_POST["customerId"])){

	$audit = new AjaxPaymentAudit();
	$audit -> customerId = $_POST["customerId"];
	$audit -> ajaxGetAuditByCustomer();

}

