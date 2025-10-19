<?php

require_once "../controllers/vendors.controller.php";
require_once "../models/vendors.model.php";

class AjaxVendors{

	/*=============================================
	EDIT VENDOR
	=============================================*/

	public $idVendor;

	public function ajaxEditVendor(){

		$item = "id";
		$value = $this->idVendor;

		$answer = ControllerVendors::ctrShowVendors($item, $value);

		echo json_encode($answer);

	}

}

/*=============================================
EDIT VENDOR
=============================================*/

if(isset($_POST["idVendor"])){

	$vendor = new AjaxVendors();
	$vendor -> idVendor = $_POST["idVendor"];
	$vendor -> ajaxEditVendor();

}

