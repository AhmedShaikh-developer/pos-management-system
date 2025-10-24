<?php

require_once "../controllers/returns.controller.php";
require_once "../models/returns.model.php";

require_once "../controllers/sales.controller.php";
require_once "../models/sales.model.php";

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

class AjaxReturns{

	/*=============================================
	GET SALE DETAILS
	=============================================*/

	public $saleId;

	public function ajaxGetSaleDetails(){

		$item = "id";
		$value = $this->saleId;

		$answer = ControllerSales::ctrShowSales($item, $value);

		echo json_encode($answer);

	}

}

/*=============================================
GET SALE DETAILS
=============================================*/

if(isset($_POST["saleId"])){

	$saleDetails = new AjaxReturns();
	$saleDetails -> saleId = $_POST["saleId"];
	$saleDetails -> ajaxGetSaleDetails();

}

