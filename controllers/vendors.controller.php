<?php

class ControllerVendors{

	/*=============================================
	CREATE VENDOR
	=============================================*/

	static public function ctrCreateVendor(){

		if(isset($_POST["newVendor"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newVendor"]) &&
			   preg_match('/^[()\-0-9 ]+$/', $_POST["newPhone"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["newAddress"])){

			   	$table = "vendors";

			   	$data = array("name"=>$_POST["newVendor"],
					           "phone"=>$_POST["newPhone"],
					           "address"=>$_POST["newAddress"]);

			   	$answer = VendorsModel::mdlAddVendor($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The vendor has been saved",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "vendors";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Vendor cannot be blank or have special characters!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "vendors";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	SHOW VENDORS
	=============================================*/

	static public function ctrShowVendors($item, $value){

		$table = "vendors";

		$answer = VendorsModel::mdlShowVendors($table, $item, $value);

		return $answer;

	}

	/*=============================================
	EDIT VENDOR
	=============================================*/

	static public function ctrEditVendor(){

		if(isset($_POST["editVendor"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editVendor"]) &&
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editPhone"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editAddress"])){

			   	$table = "vendors";

			   	$data = array("id"=>$_POST["idVendor"],
			   				   "name"=>$_POST["editVendor"],
					           "phone"=>$_POST["editPhone"],
					           "address"=>$_POST["editAddress"]);

			   	$answer = VendorsModel::mdlEditVendor($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The vendor has been updated",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "vendors";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Vendor cannot be blank or have special characters!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "vendors";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	DELETE VENDOR
	=============================================*/

	static public function ctrDeleteVendor(){

		if(isset($_GET["idVendor"])){

			$table ="vendors";
			$data = $_GET["idVendor"];

			$answer = VendorsModel::mdlDeleteVendor($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The vendor has been deleted",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {

								window.location = "vendors";

								}
							})

				</script>';

			}		

		}

	}

}

