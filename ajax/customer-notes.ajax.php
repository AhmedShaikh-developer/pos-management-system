<?php

require_once "../models/customer-notes.model.php";

if(isset($_GET["action"])){

	$action = $_GET["action"];

	// Get notes for a specific customer
	if($action == "getNotes" && isset($_GET["customerId"])){

		$customerId = $_GET["customerId"];
		$notes = ModelCustomerNotes::mdlShowCustomerNotes("customer_id", $customerId);

		echo json_encode($notes);

	}

	// Get a single note for editing
	elseif($action == "getNote" && isset($_GET["noteId"])){

		$noteId = $_GET["noteId"];
		$note = ModelCustomerNotes::mdlGetNote($noteId);

		echo json_encode($note);

	}

	// Check for active alerts
	elseif($action == "checkAlerts" && isset($_GET["customerId"])){

		$customerId = $_GET["customerId"];
		$alerts = ModelCustomerNotes::mdlCheckActiveAlerts($customerId);

		echo json_encode($alerts);

	}

	// Get notes with warnings for a customer
	elseif($action == "getWarnings" && isset($_GET["customerId"])){

		$customerId = $_GET["customerId"];
		$notes = ModelCustomerNotes::mdlShowCustomerNotes("customer_id", $customerId);

		// Filter only warnings
		$warnings = array_filter($notes, function($note){
			return $note["note_type"] == "warning";
		});

		echo json_encode(array_values($warnings));

	}

}else{

	echo json_encode(["error" => "No action specified"]);

}

