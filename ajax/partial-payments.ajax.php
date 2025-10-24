<?php

require_once "../models/partial-payments.model.php";
require_once "../models/sales.model.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET["item"]) && isset($_GET["value"])){

    $table = "sales";
    $item = $_GET["item"];
    $value = $_GET["value"];

    $sale = ModelSales::mdlShowSales($table, $item, $value);

    if($sale){
        // Debug: Log what we got from database
        error_log("=== SALE FOUND ===");
        error_log("Sale ID: " . $sale["id"]);
        error_log("Sale Code: " . $sale["code"]);
        error_log("Total Price: " . $sale["totalPrice"]);
        error_log("Net Price: " . $sale["netPrice"]);
        error_log("Payment Status: " . $sale["payment_status"]);
        
        // Get total paid amount for this sale from partial_payments table
        $totalPaid = ModelPartialPayments::mdlGetTotalPaidAmount($sale["id"]);
        $sale["amountPaid"] = $totalPaid ? $totalPaid : 0;
        
        error_log("Amount Paid: " . $sale["amountPaid"]);
        error_log("===================");
    } else {
        $sale = ["error" => "Sale not found", "debug_item" => $item, "debug_value" => $value];
        error_log("=== NO SALE FOUND ===");
        error_log("Item: " . $item);
        error_log("Value: " . $value);
        error_log("====================");
    }

    echo json_encode($sale);

} else {
    echo json_encode(["error" => "Missing parameters"]); // Return error if parameters missing
    error_log("Missing GET parameters: item or value");
}
