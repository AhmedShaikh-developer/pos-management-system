<?php

require_once "models/customer-notes.model.php";

class ControllerCustomerNotes{

	/*=============================================
	SHOW CUSTOMER NOTES
	=============================================*/

	static public function ctrShowCustomerNotes($item, $value){

		$answer = ModelCustomerNotes::mdlShowCustomerNotes($item, $value);

		return $answer;

	}

	/*=============================================
	ADD CUSTOMER NOTE
	=============================================*/

	static public function ctrAddCustomerNote(){

		if(isset($_POST["addCustomerNote"])){

			if(preg_match('/^[0-9]+$/', $_POST["customerId"]) &&
			   preg_match('/^[a-zA-Z0-9\s\.\,\!\?\-\_\(\)áéíóúÁÉÍÓÚñÑ]+$/u', $_POST["noteText"])){

				$table = "customer_notes";

				$data = array("customer_id" => $_POST["customerId"],
							 "note_text" => htmlspecialchars($_POST["noteText"], ENT_QUOTES, 'UTF-8'),
							 "note_type" => $_POST["noteType"],
							 "created_by" => $_SESSION["id"]);

				$answer = ModelCustomerNotes::mdlAddCustomerNote($table, $data);

				if($answer == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "Note Added!",
							  text: "The customer note has been successfully added.",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						}).then(function(result){

								if(result.value){
								
									window.location = "customers";
								
								}

						});

					</script>';

				}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "Error!",
							  text: "Failed to add note. Please try again.",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						});

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Invalid Data!",
						  text: "Please check the entered data. Special characters are not allowed.",
						  showConfirmButton: true,
						  confirmButtonText: "Close"

					});

				</script>';

			}

		}

	}

	/*=============================================
	EDIT CUSTOMER NOTE
	=============================================*/

	static public function ctrEditCustomerNote(){

		if(isset($_POST["editCustomerNote"])){

			if(preg_match('/^[0-9]+$/', $_POST["noteId"]) &&
			   preg_match('/^[a-zA-Z0-9\s\.\,\!\?\-\_\(\)áéíóúÁÉÍÓÚñÑ]+$/u', $_POST["noteText"])){

				$table = "customer_notes";

				$data = array("id" => $_POST["noteId"],
							 "note_text" => htmlspecialchars($_POST["noteText"], ENT_QUOTES, 'UTF-8'),
							 "note_type" => $_POST["noteType"]);

				$answer = ModelCustomerNotes::mdlEditCustomerNote($table, $data);

				if($answer == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "Note Updated!",
							  text: "The customer note has been successfully updated.",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						}).then(function(result){

								if(result.value){
								
									window.location = "customers";
								
								}

						});

					</script>';

				}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "Error!",
							  text: "Failed to update note. Please try again.",
							  showConfirmButton: true,
							  confirmButtonText: "Close"

						});

					</script>';

				}

			}

		}

	}

	/*=============================================
	DELETE CUSTOMER NOTE
	=============================================*/

	static public function ctrDeleteCustomerNote(){

		if(isset($_GET["idNote"])){

			$table ="customer_notes";
			$data = $_GET["idNote"];

			$answer = ModelCustomerNotes::mdlDeleteCustomerNote($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "Note Deleted!",
					  text: "The customer note has been successfully deleted.",
					  showConfirmButton: true,
					  confirmButtonText: "Close"

				}).then(function(result){

						if(result.value){
						
							window.location = "customers";
						
						}

				});

			</script>';

			}

		}

	}

	/*=============================================
	CHECK FOR CUSTOMER ALERTS
	=============================================*/

	static public function ctrCheckCustomerAlerts($customerId){

		$alerts = ModelCustomerNotes::mdlCheckActiveAlerts($customerId);

		$hasWarning = false;
		$hasReminder = false;
		$hasInfo = false;

		if($alerts){
			foreach($alerts as $alert){
				if($alert["note_type"] == "warning" && $alert["count"] > 0){
					$hasWarning = true;
				}
				if($alert["note_type"] == "reminder" && $alert["count"] > 0){
					$hasReminder = true;
				}
				if($alert["note_type"] == "info" && $alert["count"] > 0){
					$hasInfo = true;
				}
			}
		}

		return array(
			"has_warning" => $hasWarning,
			"has_reminder" => $hasReminder,
			"has_info" => $hasInfo
		);

	}

}

