<?php

require_once "../controllers/purchases.controller.php";
require_once "../models/purchases.model.php";

require_once "../controllers/vendors.controller.php";
require_once "../models/vendors.model.php";

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

class AjaxPurchases{

	/*=============================================
	GET VENDOR BALANCE
	=============================================*/

	public $vendorId;

	public function ajaxGetVendorBalance(){

		$answer = ControllerPurchases::ctrGetVendorBalance($this->vendorId);

		echo json_encode($answer);

	}

}

/*=============================================
GET VENDOR BALANCE
=============================================*/

if(isset($_POST["vendorId"])){

	$balance = new AjaxPurchases();
	$balance -> vendorId = $_POST["vendorId"];
	$balance -> ajaxGetVendorBalance();

}

