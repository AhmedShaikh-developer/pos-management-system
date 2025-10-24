<?php

require_once "../models/partial-payments.model.php";

$saleId = $_GET["saleId"];

$payments = ModelPartialPayments::mdlGetPaymentHistory($saleId);

echo json_encode($payments);
